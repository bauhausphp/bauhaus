<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DiscoverableA1;
use Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA\DiscoverableA2;

class DiscoverableB
{
    public function __construct(
        private DiscoverableA1 $a,
        private DiscoverableA2 $b,
    ) {
    }
}
