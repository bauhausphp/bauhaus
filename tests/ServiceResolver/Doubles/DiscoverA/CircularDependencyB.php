<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

class CircularDependencyB
{
    public function __construct(
        private CircularDependencyA $a,
    ) {
    }
}
