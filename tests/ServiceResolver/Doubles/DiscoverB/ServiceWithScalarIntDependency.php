<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

class ServiceWithScalarIntDependency
{
    public function __construct(
        private int $int,
    ) {
    }
}
