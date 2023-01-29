<?php

namespace Bauhaus\Tests\Http\Message\Request;

trait MethodDataProvider
{
    public function validMethods(): iterable
    {
        yield 'GET' => ['GET'];
        yield 'HEAD' => ['HEAD'];
        yield 'POST' => ['POST'];
        yield 'PUT' => ['PUT'];
        yield 'DELETE' => ['DELETE'];
        yield 'CONNECT' => ['CONNECT'];
        yield 'OPTIONS' => ['OPTIONS'];
        yield 'TRACE' => ['TRACE'];
    }
}
