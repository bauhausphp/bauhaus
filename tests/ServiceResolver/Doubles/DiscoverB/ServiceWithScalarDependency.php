<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

class ServiceWithScalarDependency
{
    public function __construct(
        private int $integer,
    ) {
    }
}
