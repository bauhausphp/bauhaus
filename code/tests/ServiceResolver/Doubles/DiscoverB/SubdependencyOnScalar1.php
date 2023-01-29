<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

class SubdependencyOnScalar1
{
    public function __construct(
        private ServiceWithScalarIntDependency $x,
    ) {
    }
}
