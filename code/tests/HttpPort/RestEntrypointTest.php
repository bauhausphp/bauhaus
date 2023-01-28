<?php

namespace Bauhaus\Tests\HttpPort;

use Bauhaus\HttpPortSettings;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface as PsrHandlerInterface;

class RestEntrypointTest extends TestCase
{
    /** @test */
    public function start(): void
    {
        $settings = HttpPortSettings::new();

        $httpPort = $settings->build();

        self::assertInstanceOf(PsrHandlerInterface::class, $httpPort);
    }
}
