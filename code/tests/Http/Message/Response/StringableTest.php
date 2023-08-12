<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Http\Message\ResponseFactory;
use Bauhaus\Http\Message\StringBody;
use PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    /** @test */
    public function haveEmptyHeadersByDefault(): void
    {
        $response = ResponseFactory::default()
            ->createResponse()
            ->withProtocolVersion('1.0')
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Custom', ['Einstein', 'Newton'])
            ->withBody(StringBody::with('{"field":"value"}'));

        $string = (string) $response;

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
