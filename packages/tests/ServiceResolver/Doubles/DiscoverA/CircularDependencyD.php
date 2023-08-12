<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

class CircularDependencyD
{
    public function __construct(
        private CircularDependencyC $c,
    ) {
    }
}
