<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

class ServiceWithDependenciesWithoutType
{
    public function __construct(
        private $x,
    ) {
    }
}
