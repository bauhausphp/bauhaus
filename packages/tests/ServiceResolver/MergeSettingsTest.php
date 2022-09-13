<?php

namespace Bauhaus\Tests\ServiceResolver;

use Bauhaus\ServiceResolverSettings;
use PHPUnit\Framework\TestCase;

class MergeSettingsTest extends TestCase
{
    /**
     * @test
     */
    public function keepValuesFromBothSettings(): void
    {
        $settings1 = ServiceResolverSettings::new()
            ->withDefinitionFiles('file11', 'file12')
            ->withDiscoverableNamespaces('namespace11', 'namespace12')
            ->withServices(['service1' => new \DateTime()]);
        $settings2 = ServiceResolverSettings::new()
            ->withDefinitionFiles('file21', 'file22')
            ->withDiscoverableNamespaces('namespace21', 'namespace22')
            ->withServices(['service2' => new \DateTime()]);

        $mergedSettings = $settings1->mergedWith($settings2);

        $expected = ServiceResolverSettings::new()
            ->withDefinitionFiles('file11', 'file12', 'file21', 'file22')
            ->withDiscoverableNamespaces('namespace11', 'namespace12', 'namespace21', 'namespace22')
            ->withServices(['service1' => new \DateTime(), 'service2' => new \DateTime()]);
        self::assertEquals($expected, $mergedSettings);
    }
}
