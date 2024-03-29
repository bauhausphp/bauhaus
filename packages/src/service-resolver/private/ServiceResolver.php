<?php

namespace Bauhaus\ServiceResolver;

use Bauhaus\ServiceResolver\CircularDependencyDetector\CircularDependencyDetector;
use Bauhaus\ServiceResolver\Container\ProvidedServiceContainer;
use Bauhaus\ServiceResolver\Discoverer\Discoverer;
use Bauhaus\ServiceResolver\MemoryCache\MemoryCache;
use Bauhaus\ServiceResolver\SelfPsrContainerLocator\SelfPsrContainerDetector;
use Bauhaus\ServiceResolverSettings;
use Psr\Container\ContainerInterface as PsrContainer;
use Throwable;

/**
 * @internal
 */
final readonly class ServiceResolver implements PsrContainer
{
    private function __construct(
        private Locator $locator,
    ) {
    }

    public static function build(ServiceResolverSettings $settings): self
    {
        $container = ProvidedServiceContainer::build($settings);
        $selfDetector = new SelfPsrContainerDetector($container);
        $discoverer = new Discoverer($settings, $selfDetector);
        $circularDetector = new CircularDependencyDetector($discoverer);
        $memoryCache = new MemoryCache($circularDetector);

        return new self($memoryCache);
    }

    public function has(string $id): bool
    {
        return null !== $this->findDefinition($id);
    }

    /**
     * @throws DefinitionNotFound
     * @throws DefinitionLoadingError
     */
    public function get(string $id)
    {
        if (!$this->has($id)) {
            throw new DefinitionNotFound($id);
        }

        return $this->evaluateDefinition($id);
    }

    private function findDefinition(string $id): ?Definition
    {
        return $this->locator->find(new Identifier($id));
    }

    private function evaluateDefinition(string $id): object
    {
        $definition = $this->findDefinition($id);

        try {
            return $definition->load($this);
        } catch (DefinitionLoadingError $ex) {
            throw DefinitionLoadingError::trace($ex, $id);
        } catch (Throwable $ex) {
            throw DefinitionLoadingError::becauseOf($ex, $id);
        }
    }
}
