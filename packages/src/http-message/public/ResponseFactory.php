<?php

namespace Bauhaus\Http;

use Bauhaus\Http\Message\Headers\Headers;
use Bauhaus\Http\Message\Protocol;
use Bauhaus\Http\Message\Response\Status;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactory;
use Psr\Http\Message\ResponseInterface as PsrResponse;

final class ResponseFactory implements PsrResponseFactory
{
    private function __construct(
        private Protocol $protocol,
        private Headers $headers,
    ) {
    }

    public static function withDefaults(): self
    {
        return new self(Protocol::V_1_1, Headers::empty());
    }

    public function createResponse(int $code = 200, string $reasonPhrase = ''): PsrResponse
    {
        $status = Status::fromInput($code, $reasonPhrase);

        return new Response($this->protocol, $status, $this->headers);
    }
}
