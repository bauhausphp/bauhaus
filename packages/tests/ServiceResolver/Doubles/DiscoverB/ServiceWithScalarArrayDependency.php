<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

class ServiceWithScalarArrayDependency
{
    public function __construct(
        private array $arr,
    ) {
    }
}
