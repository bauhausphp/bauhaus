<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

class ServiceWithScalarStringDependency
{
    public function __construct(
        private string $string,
    ) {
    }
}
