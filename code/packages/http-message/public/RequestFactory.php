<?php

namespace Bauhaus\Http\Message;

use Bauhaus\Http\Message\Request\Method;
use Psr\Http\Message\RequestFactoryInterface as PsrRequestFactory;
use Psr\Http\Message\RequestInterface as PsrRequest;
use Psr\Http\Message\StreamInterface as PsrStream;

final class RequestFactory implements PsrRequestFactory
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

    public function createRequest(string $method, $uri): PsrRequest
    {
        $method = Method::fromString($method);

        return new Request($this->protocol, $method, $this->headers, $this->body);
    }
}
