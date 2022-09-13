<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

use DateTime;

class ServiceWithVariadicDependency
{
    public function __construct(DateTime ...$classes)
    {
    }
}
