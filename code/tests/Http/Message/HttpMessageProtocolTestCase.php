<?php

namespace Bauhaus\Tests\Http\Message;

use Generator;
use InvalidArgumentException;

abstract class HttpMessageProtocolTestCase extends HttpMessageTestCase
{
    public function supportedVersions(): Generator
    {
        yield '1.0' => ['1.0'];
        yield '1.1' => ['1.1'];
    }

    /** @test @dataProvider supportedVersions */
    public function createNewInstanceWithProvidedProtocol(string $version): void
    {
        $message = $this->message->withProtocolVersion($version);

        self::assertEquals($version, $message->getProtocolVersion());
    }

    public function unsupportedVersions(): Generator
    {
        yield 'banana' => ['banana'];
        yield '0.9' => ['0.9'];
    }

    /** @test @dataProvider unsupportedVersions */
    public function throwExceptionIfProvidedProtocolIsInvalid(string $version): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Invalid protocol');

        $this->message->withProtocolVersion($version);
    }
}
