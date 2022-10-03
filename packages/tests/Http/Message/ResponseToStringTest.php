<?php

namespace Bauhaus\Tests\Http\Message;

class ResponseToStringTest extends ResponseTestCase
{
    /** @test */
    public function haveEmptyHeadersByDefault(): void
    {
        $response = $this->response
            ->withProtocolVersion('1.0')
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Custom', ['Einstein', 'Newton']);

        $string = $response->toString();

        $this->assertEquals(
            <<<STR
            HTTP/1.0 404 Not Found
            Content-Type: application/json
            X-Custom: Einstein, Newton

            {}
            STR,
            $string
        );
    }
}
