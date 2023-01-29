<?php

namespace Bauhaus\Tests\HttpPort;

use Bauhaus\HttpPortSettings;
use Bauhaus\Tests\Doubles\FakePsrServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface as PsrHandlerInterface;

class RestEntrypointTest extends TestCase
{
    /** @test */
    public function start(): void
    {
        $settings = HttpPortSettings::new();

        $httpPort = $settings->build();
        $response = $httpPort->handle(new FakePsrServerRequest('GET', '/asd'));

        self::assertInstanceOf(PsrHandlerInterface::class, $httpPort);
    }
}
