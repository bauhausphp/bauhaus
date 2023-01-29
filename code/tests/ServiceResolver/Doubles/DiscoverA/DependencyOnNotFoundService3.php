<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

class DependencyOnNotFoundService3
{
    public function __construct(
        private DependencyOnNotFoundService2 $x,
    ) {
    }
}
