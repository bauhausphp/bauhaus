<?php

namespace Bauhaus\Tests\Http\Message\Request;

use Bauhaus\Http\Message\Body;

class StringCastTest extends TestCase
{
    /** @test */
    public function haveEmptyHeadersByDefault(): void
    {
        $request = $this->request
            ->withProtocolVersion('1.0')
            ->withMethod('POST')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Custom', ['Einstein', 'Newton'])
            ->withBody(Body::fromString('{"field":"value"}'));

        $string = $request->toString();

        $this->assertEquals(
            <<<STR
            HTTP/1.0 POST /target/path
            Content-Type: application/json
            X-Custom: Einstein, Newton

            {"field":"value"}
            STR,
            $string
        );
    }
}
