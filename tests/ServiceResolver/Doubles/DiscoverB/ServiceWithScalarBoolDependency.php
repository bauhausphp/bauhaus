<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

class ServiceWithScalarBoolDependency
{
    public function __construct(
        private bool $bool,
    ) {
    }
}
