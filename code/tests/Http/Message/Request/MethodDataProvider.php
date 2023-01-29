<?php

namespace Bauhaus\Tests\Http\Message\Request;

trait MethodDataProvider
{
    public function validMethods(): iterable
    {
        // todo add all of them
        foreach (['GET', 'POST', 'PUT'] as $method) {
            yield "$method" => [$method];
        }
    }
}
