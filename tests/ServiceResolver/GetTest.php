<?php

namespace Bauhaus\Tests\ServiceResolver;

use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\AbstractClassInADiscoverableNamespace;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\CircularDependencyA;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\CircularDependencyB;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\CircularDependencyC;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\CircularDependencyD;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService1;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService2;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService3;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DiscoverableA1;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DiscoverableA2;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\InterfaceInADiscoverableNamespace;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\ServiceThatThrowsException;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\ServiceWithManyDependencies;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\DiscoverableB;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithDependenciesWithoutType;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarArrayDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarBoolDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarFloatDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarIntDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarStringDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithVariadicDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\SubdependencyOnScalar1;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\SubdependencyOnScalar2;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\ServiceWithOneDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\ServiceWithoutDependencyA;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\ServiceWithoutDependencyB;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\Unresolvable;
use PHPUnit\Framework\TestCase;
use Psr\Container\NotFoundExceptionInterface as PsrNotFoundException;
use Psr\Container\ContainerExceptionInterface as PsrContainerException;

class GetTest extends TestCase
{
    use ServiceResolverSetup;

    public function idsWithExpectedClasses(): array
    {
        return [
            'callable without dependency #1'
                => ['callable', ServiceWithoutDependencyA::class],
            'callable without dependency #2'
                => [ServiceWithoutDependencyA::class, ServiceWithoutDependencyA::class],
            'callable with psr container as dependency'
                => [ServiceWithOneDependency::class, ServiceWithOneDependency::class],
            'callable with another service as dependency'
                => ['callable-with-dependency', ServiceWithOneDependency::class],
            'concrete object #1'
                => ['concrete-object', ServiceWithoutDependencyB::class],
            'concrete object #2'
                => ['without-callback', \StdClass::class],
            'concrete object #3'
                => ['without-callback', \StdClass::class],
            'alias to callable'
                => ['alias-to-callable', ServiceWithoutDependencyA::class],
            'alias to concrete object'
                => ['alias-to-concrete-object', ServiceWithoutDependencyB::class],
            'alias to discoverable'
                => ['alias-to-discoverable', DiscoverableA1::class],
            'alias to class name'
                => ['service-alias', ServiceWithoutDependencyA::class],
            'discoverable without dependency'
                => [DiscoverableA1::class, DiscoverableA1::class],
            'discoverable with one dependency'
                => [DiscoverableA2::class, DiscoverableA2::class],
            'discoverable with two dependencies'
                => [DiscoverableB::class, DiscoverableB::class],
            'discoverable with many dependencies'
                => [ServiceWithManyDependencies::class, ServiceWithManyDependencies::class],
            'discoverable with scalar dependency but provided from file'
                => [ServiceWithScalarDependency::class, ServiceWithScalarDependency::class]
        ];
    }

    /**
     * @test
     * @dataProvider idsWithExpectedClasses
     */
    public function returnServiceInstanceByItsIdIfItWasWellDefined(string $id, string $expected): void
    {
        $service = $this->resolver->get($id);

        self::assertInstanceOf($expected, $service);
    }

    /**
     * @test
     * @dataProvider idsWithExpectedClasses
     */
    public function alwaysReturnSameServiceInstanceByItsId(string $id): void
    {
        $firstInstance = $this->resolver->get($id);

        $secondInstance = $this->resolver->get($id);

        self::assertSame($firstInstance, $secondInstance);
    }

    public function idsWithoutDefinition(): array
    {
        return [
            'non existing id'
                => ['non-existing-id'],
            'out of any discoverable namespace #1'
                => [\StdClass::class],
            'out of any discoverable namespace #2'
                => [\DateTime::class],
            'out of any discoverable namespace #3'
                => [Unresolvable::class],
            'interface among discoverable namespace'
                => [InterfaceInADiscoverableNamespace::class],
            'abstract class among discoverable namespace'
                => [AbstractClassInADiscoverableNamespace::class],
        ];
    }

    /**
     * @test
     * @dataProvider idsWithoutDefinition
     */
    public function throwPsrNotFoundExceptionIfProvidedIdHasNoDefinition(string $id): void
    {
        self::expectException(PsrNotFoundException::class);
        self::expectExceptionMessage("No definition found with id $id");

        $this->resolver->get($id);
    }

    public function idsWithCircularDependency(): array
    {
        $d = CircularDependencyD::class;
        $c = CircularDependencyC::class;
        $b = CircularDependencyB::class;
        $a = CircularDependencyA::class;

        return [
            'two levels stack' => [
                $b,
                <<<MSG
                Definition evaluation error
                    requested id -> $b
                     V
                    dependency id -> $a
                     V
                    dependency id -> $b
                     > Circular dependency detected
                MSG,
            ],
            'three levels stack' => [
                $c,
                <<<MSG
                Definition evaluation error
                    requested id -> $c
                     V
                    dependency id -> $b
                     V
                    dependency id -> $a
                     V
                    dependency id -> $b
                     > Circular dependency detected
                MSG,
            ],
            'four levels stack' => [
                $d,
                <<<MSG
                Definition evaluation error
                    requested id -> $d
                     V
                    dependency id -> $c
                     V
                    dependency id -> $b
                     V
                    dependency id -> $a
                     V
                    dependency id -> $b
                     > Circular dependency detected
                MSG,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider idsWithCircularDependency
     */
    public function throwPsrContainerExceptionIfCircularDependencyIsDetected(
        string $id,
        string $expectedMessage,
    ): void {
        self::expectException(PsrContainerException::class);
        self::expectExceptionMessage($expectedMessage);

        $this->resolver->get($id);
    }

    public function idsOfDiscoverableServicesWithScalarDependency(): array
    {
        return [
            'dependency without type' => [
                ServiceWithDependenciesWithoutType::class, <<<MSG
                  Definition evaluation error
                      requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithDependenciesWithoutType
                       > Cannot load dependency without type: \$x
                  MSG,
            ],
            'dependency on array' => [
                ServiceWithScalarArrayDependency::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarArrayDependency
                         > Cannot load primitive type dependency: array \$arr
                    MSG,
            ],
            'dependency on boolean' => [
                ServiceWithScalarBoolDependency::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarBoolDependency
                         > Cannot load primitive type dependency: bool \$bool
                    MSG,
            ],
            'dependency on integer' => [
                ServiceWithScalarIntDependency::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarIntDependency
                         > Cannot load primitive type dependency: int \$int
                    MSG,
            ],
            'dependency on float' => [
                ServiceWithScalarFloatDependency::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarFloatDependency
                         > Cannot load primitive type dependency: float \$float
                    MSG,
            ],
            'dependency on string' => [
                ServiceWithScalarStringDependency::class, <<<MSG
                   Definition evaluation error
                       requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarStringDependency
                        > Cannot load primitive type dependency: string \$string
                   MSG,
            ],
            'dependency on variadic' => [
                ServiceWithVariadicDependency::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithVariadicDependency
                         > Cannot load variadic dependency: StdClass ...\$classes
                    MSG,
            ],
            'sub-dependency on primitive' => [
                SubdependencyOnScalar1::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\SubdependencyOnScalar1
                         V
                        dependency id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarIntDependency
                         > Cannot load primitive type dependency: int \$int
                    MSG,
            ],
            'sub-sub-dependency on primitive' => [
                SubdependencyOnScalar2::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\SubdependencyOnScalar2
                         V
                        dependency id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\SubdependencyOnScalar1
                         V
                        dependency id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarIntDependency
                         > Cannot load primitive type dependency: int \$int
                    MSG,
            ],
            'dependency not found' => [
                DependencyOnNotFoundService1::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService1
                         > Cannot find dependency: Bauhaus\Tests\ServiceResolver\Doubles\NotFoundService \$x
                    MSG,
            ],
            'sub-dependency not found' => [
                DependencyOnNotFoundService2::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService2
                         V
                        dependency id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService1
                         > Cannot find dependency: Bauhaus\Tests\ServiceResolver\Doubles\NotFoundService \$x
                    MSG,
            ],
            'sub-sub-dependency not found' => [
                DependencyOnNotFoundService3::class, <<<MSG
                    Definition evaluation error
                        requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService3
                         V
                        dependency id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService2
                         V
                        dependency id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DependencyOnNotFoundService1
                         > Cannot find dependency: Bauhaus\Tests\ServiceResolver\Doubles\NotFoundService \$x
                    MSG,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider idsOfDiscoverableServicesWithScalarDependency
     */
    public function throwPsrContainerExceptionIfDiscoverableServiceHasUnresolvableDependency(
        string $id,
        string $expectedMessage
    ): void {
        self::expectException(PsrContainerException::class);
        self::expectExceptionMessage($expectedMessage);

        $this->resolver->get($id);
    }

    /**
     * @test
     */
    public function throwPsrContainerExceptionIfServiceThrowsExceptionWhenInitiated(): void
    {
        self::expectException(PsrContainerException::class);
        self::expectExceptionMessage(<<<MSG
            Definition evaluation error
                requested id -> Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\ServiceThatThrowsException
                 > Error occurred
            MSG);

        $this->resolver->get(ServiceThatThrowsException::class);
    }
}
