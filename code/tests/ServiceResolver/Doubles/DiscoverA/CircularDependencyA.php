<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

class CircularDependencyA
{
    public function __construct(
        private CircularDependencyB $b,
    ) {
    }
}
