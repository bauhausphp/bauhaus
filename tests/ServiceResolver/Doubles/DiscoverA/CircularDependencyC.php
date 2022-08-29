<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

class CircularDependencyC
{
    public function __construct(
        private CircularDependencyB $b,
    ) {
    }
}
