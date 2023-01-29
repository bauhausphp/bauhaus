<?php

namespace Bauhaus\Tests\Http\Message\Request;

use Bauhaus\Http\Message\RequestFactory;
use Bauhaus\Http\Message\StringBody;
use PHPUnit\Framework\TestCase;

class StringableTest extends TestCase
{
    /** @test */
    public function haveEmptyHeadersByDefault(): void
    {
        $request = RequestFactory::default()
            ->createRequest('POST', 'https://host/path/path')
            ->withProtocolVersion('1.0')
            ->withMethod('POST')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('X-Custom', ['Einstein', 'Newton'])
            ->withBody(StringBody::with('{"field":"value"}'));

        $string = (string) $request;

        // TODO uri
        $this->assertEquals(
            <<<STR
            HTTP/1.0 POST
            Content-Type: application/json
            X-Custom: Einstein, Newton

            {"field":"value"}
            STR,
            $string
        );
    }
}
