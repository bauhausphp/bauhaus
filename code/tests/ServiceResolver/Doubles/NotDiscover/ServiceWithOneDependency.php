<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover;

class ServiceWithOneDependency
{
    public function __construct(
        private ServiceWithoutDependencyA $dep,
    ) {
    }
}
