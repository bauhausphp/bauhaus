<?php

namespace Bauhaus\Tests\Http\Message\Response;

use Bauhaus\Http\Message\UnsupportedProtocol;

class ResponseProtocolMutationTest extends ResponseTestCase
{
    /**
     * @test
     * @dataProvider supportedVersions
     */
    public function newInstanceContainsNewVersion(string $version): void
    {
        $response = $this->response->withProtocolVersion($version);

        $this->assertEquals($version, $response->getProtocolVersion());
    }

    public function supportedVersions(): array
    {
        return [
            '1.0' => ['1.0'],
            '1.1' => ['1.1'],
        ];
    }

    /**
     * @test
     * @dataProvider unsupportedVersions
     */
    public function throwExceptionIfProvidedProtocolIsUnsupported(string $version): void
    {
        $this->expectException(UnsupportedProtocol::class);

        $this->response->withProtocolVersion($version);
    }

    public function unsupportedVersions(): array
    {
        return [
            'banana' => ['banana'],
            '0.9' => ['0.9'],
        ];
    }
}
