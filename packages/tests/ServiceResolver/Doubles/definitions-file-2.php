<?php

use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\ServiceWithoutDependencyA;
use Bauhaus\Tests\ServiceResolver\Doubles\NotDiscover\CallableService;

return [
    'service-alias' => ServiceWithoutDependencyA::class,
    'without-callback' => new stdClass(),
    'concrete-callable-object' => new CallableService(),
];
