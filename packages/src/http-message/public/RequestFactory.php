<?php

namespace Bauhaus\Http\Message;

use Bauhaus\Http\Message\Request\Method;
use Psr\Http\Message\RequestFactoryInterface as PsrRequestFactory;
use Psr\Http\Message\RequestInterface as PsrRequest;

final class RequestFactory implements PsrRequestFactory
{
    private function __construct(
        private Protocol $protocol,
        private Headers $headers,
        private Body $body,
    ) {
    }

    public static function withDefaults(): self
    {
        return new self(Protocol::V_1_1, Headers::empty(), Body::empty());
    }

    public function createRequest(string $method, $uri): PsrRequest
    {
        $method = Method::fromString($method);

        return new Request($this->protocol, $method, $this->headers, $this->body);
    }
}
