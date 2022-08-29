<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

use StdClass;

class ServiceWithVariadicDependency
{
    public function __construct(StdClass ...$classes)
    {
    }
}
