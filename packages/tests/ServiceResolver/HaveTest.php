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
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarArrayDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarBoolDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarDependencies;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarIntDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithScalarStringDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\ServiceWithVariadicDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\SubdependencyOnScalar1;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\SubdependencyOnScalar2;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\ServiceWithOneDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\ServiceWithoutDependencyA;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\Unresolvable;
use PHPUnit\Framework\TestCase;

class HaveTest extends TestCase
{
    use ServiceResolverSetup;

    public function idsWithDefinition(): array
    {
        return [
            'directly provided #1' => ['callable'],
            'directly provided #2' => ['concrete-object'],
            'from definition file #1' => [ServiceWithOneDependency::class],
            'from definition file #2' => [ServiceWithoutDependencyA::class],
            'from definition file #3' => ['without-callback'],
            'from definition file #4' => ['service-alias'],
            'alias #1' => ['alias-to-callable'],
            'alias #2' => ['alias-to-concrete-object'],
            'alias #3' => ['alias-to-discoverable'],
            'alias #4' => ['alias-to-non-existing-id'],
            'in a discoverable namespace #01' => [CircularDependencyA::class],
            'in a discoverable namespace #02' => [CircularDependencyB::class],
            'in a discoverable namespace #03' => [CircularDependencyC::class],
            'in a discoverable namespace #04' => [CircularDependencyD::class],
            'in a discoverable namespace #05' => [DiscoverableA1::class],
            'in a discoverable namespace #06' => [DiscoverableA2::class],
            'in a discoverable namespace #07' => [DependencyOnNotFoundService1::class],
            'in a discoverable namespace #08' => [DependencyOnNotFoundService2::class],
            'in a discoverable namespace #09' => [DependencyOnNotFoundService3::class],
            'in a discoverable namespace #10' => [ServiceThatThrowsException::class],
            'in a discoverable namespace #11' => [ServiceWithManyDependencies::class],
            'in a discoverable namespace #12' => [DiscoverableB::class],
            'in a discoverable namespace #14' => [ServiceWithScalarArrayDependency::class],
            'in a discoverable namespace #15' => [ServiceWithScalarBoolDependency::class],
            'in a discoverable namespace #16' => [ServiceWithScalarDependencies::class],
            'in a discoverable namespace #17' => [ServiceWithScalarIntDependency::class],
            'in a discoverable namespace #18' => [ServiceWithScalarStringDependency::class],
            'in a discoverable namespace #19' => [ServiceWithVariadicDependency::class],
            'in a discoverable namespace #20' => [SubdependencyOnScalar1::class],
            'in a discoverable namespace #21' => [SubdependencyOnScalar2::class],
            'in a discoverable namespace and provided from file' => [ServiceWithScalarDependency::class],
        ];
    }

    /**
     * @test
     * @dataProvider idsWithDefinition
     */
    public function returnTrueIfThereIsADefinitionWithProvidedId(string $id): void
    {
        self::assertTrue($this->resolver->has($id));
    }

    public function idsWithoutDefinition(): array
    {
        return [
            'non existing id' => ['non-existing-id'],
            'out of any discoverable namespace #1' => [\stdClass::class],
            'out of any discoverable namespace #2' => [\stdClass::class],
            'out of any discoverable namespace #3' => [Unresolvable::class],
            'interface among discoverable namespace' => [InterfaceInADiscoverableNamespace::class],
            'abstract class among discoverable namespace' => [AbstractClassInADiscoverableNamespace::class],
        ];
    }

    /**
     * @test
     * @dataProvider idsWithoutDefinition
     */
    public function returnFalseIfThereIsNoDefinitionWithProvidedId(string $id): void
    {
        self::assertFalse($this->resolver->has($id));
    }
}
