<?php

namespace Bauhaus\Http\Message;

use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactory;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Psr\Http\Message\StreamInterface as PsrStream;

final readonly class ResponseFactory implements PsrResponseFactory
{
    private function __construct(
        private Protocol $protocol,
        private Headers $headers,
        private PsrStream $body,
    ) {
    }

    public static function default(): PsrResponseFactory
    {
        return new self(Protocol::version1dot1(), Headers::empty(), StringBody::empty());
    }

    public function createResponse(int $code = 200, string $reasonPhrase = ''): PsrResponse
    {
        return new Response(
            $this->protocol,
            Response\Status::with($code, $reasonPhrase),
            $this->headers,
            $this->body,
        );
    }
}
