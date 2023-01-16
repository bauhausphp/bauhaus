<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

class DiscoverableA2
{
    public function __construct(
        private DiscoverableA1 $a,
    ) {
    }
}
