<?php

namespace Bauhaus\Tests\Http\Message\Request;

use Bauhaus\Tests\Http\Message\HttpMessageTestCase;

class MethodTest extends HttpMessageTestCase
{
    use MethodDataProvider;

    /** @test @dataProvider validMethods */
    public function mutateMethod(string $method): void
    {
        $request = $this->message->withMethod($method);

        $this->assertEquals($method, $request->getMethod());
    }
}
