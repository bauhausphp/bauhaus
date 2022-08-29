<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

class ServiceWithScalarFloatDependency
{
    public function __construct(
        private float $float,
    ) {
    }
}
