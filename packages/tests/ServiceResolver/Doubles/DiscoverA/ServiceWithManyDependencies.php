<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB\DiscoverableB;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\ServiceWithOneDependency;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\ServiceWithoutDependencyA;

class ServiceWithManyDependencies
{
    public function __construct(
        private ServiceWithoutDependencyA $a,
        private ServiceWithOneDependency $b,
        private DiscoverableA1 $c,
        private DiscoverableA2 $d,
        private DiscoverableB $e,
    ) {
    }
}
