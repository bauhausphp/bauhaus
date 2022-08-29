<?php

namespace Bauhaus\Tests\ServiceResolver\Doubles\DiscoverA;

use Exception;

class ServiceThatThrowsException
{
    public function __construct()
    {
        throw new Exception('Error occurred');
    }
}
