<?php

namespace Bauhaus\HttpPort;

use Bauhaus\HttpPortSettings;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Psr\Http\Message\ServerRequestInterface as PsrServerRequest;
use Psr\Http\Server\RequestHandlerInterface as PsrHandlerInterface;

/**
 * @internal
 */
final readonly class HttpPort implements PsrHandlerInterface
{
    public static function build(HttpPortSettings $settings): self
    {
        return new self();
    }

    public function handle(PsrServerRequest $request): PsrResponse
    {
    }
}
