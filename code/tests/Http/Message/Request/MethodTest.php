<?php

namespace Bauhaus\Tests\Http\Message\Request;

class MethodTest extends TestCase
{
    private const VALID_METHODS = ['GET', 'POST', 'PUT'];
    private const INVALID_METHODS = ['invalid'];

    /** @test @dataProvider validMethods */
    public function mutateMethod(string $method): void
    {
        $request = $this->request->withMethod($method);

        $this->assertEquals($method, $request->getMethod());
    }

    public function validMethods(): iterable
    {
        foreach (self::VALID_METHODS as $method) {
            yield $method => [$method];
        }
    }
}
