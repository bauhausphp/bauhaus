<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Http\Message\Body;

class StringCastTest extends TestCase
{
    /** @test */
    public function haveEmptyHeadersByDefault(): void
    {
        $response = $this->response
            ->withProtocolVersion('1.0')
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Custom', ['Einstein', 'Newton'])
            ->withBody(Body::fromString('{"field":"value"}'));

        $string = $response->toString();

        $this->assertEquals(
            <<<STR
            HTTP/1.0 404 Not Found
            Content-Type: application/json
            X-Custom: Einstein, Newton

            {"field":"value"}
            STR,
            $string
        );
    }
}
