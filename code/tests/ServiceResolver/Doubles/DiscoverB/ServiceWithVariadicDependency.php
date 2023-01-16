<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverB;

use stdClass;

class ServiceWithVariadicDependency
{
    public function __construct(stdClass ...$classes)
    {
    }
}
