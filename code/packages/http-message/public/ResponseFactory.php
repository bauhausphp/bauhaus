<?php

namespace Bauhaus\Http\Message;

use Bauhaus\Http\Message\Response\Status;
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

    public static function default(): self
    {
        return new self(Protocol::version1dot1(), Headers::empty(), StringBody::empty());
    }

    public function createResponse(int $code = 200, string $reasonPhrase = ''): PsrResponse
    {
        $status = Status::with($code, $reasonPhrase);

        return new Response($this->protocol, $status, $this->headers, $this->body);
    }
}
