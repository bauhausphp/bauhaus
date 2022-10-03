<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Http\UnsupportedProtocol;

class ProtocolTest extends TestCase
{
    private const SUPPORTED_VERSIONS = ['1.0', '1.1'];
    private const UNSUPPORTED_VERSIONS = ['banana', '0.9'];

    /** @test @dataProvider supportedVersions */
    public function newInstanceContainsNewVersion(string $version): void
    {
        $response = $this->response->withProtocolVersion($version);

        $this->assertEquals($version, $response->getProtocolVersion());
    }

    /** @test @dataProvider unsupportedVersions */
    public function throwExceptionIfProvidedProtocolIsUnsupported(string $version): void
    {
        $this->expectException(UnsupportedProtocol::class);

        $this->response->withProtocolVersion($version);
    }

    public function supportedVersions(): \Generator
    {
        foreach (self::SUPPORTED_VERSIONS as $v) {
            yield $v => [$v];
        }
    }

    public function unsupportedVersions(): \Generator
    {
        foreach (self::UNSUPPORTED_VERSIONS as $v) {
            yield $v => [$v];
        }
    }
}
