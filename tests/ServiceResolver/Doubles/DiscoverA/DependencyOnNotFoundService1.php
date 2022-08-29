<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

use Bauhaus\Tests\ServiceResolver\Doubles\NotFoundService;

class DependencyOnNotFoundService1
{
    public function __construct(
        private NotFoundService $x,
    ) {
    }
}
