<?php

namespace Bauhaus\Tests\Doubles;

use Psr\Http\Message\ServerRequestInterface as PsrServerRequest;
use Psr\Http\Message\StreamInterface as PsrStream;
use Psr\Http\Message\UriInterface as PsrUri;

final readonly class FakePsrServerRequest implements PsrServerRequest
{
    public function __construct(
        private string $method,
        private string $path,
    ) {
    }

    public function getProtocolVersion()
    {
        throw new NotImplemented();
    }

    public function withProtocolVersion($version)
    {
        throw new NotImplemented();
    }

    public function getHeaders()
    {
        throw new NotImplemented();
    }

    public function hasHeader($name)
    {
        throw new NotImplemented();
    }

    public function getHeader($name)
    {
        throw new NotImplemented();
    }

    public function getHeaderLine($name)
    {
        throw new NotImplemented();
    }

    public function withHeader($name, $value)
    {
        throw new NotImplemented();
    }

    public function withAddedHeader($name, $value)
    {
        throw new NotImplemented();
    }

    public function withoutHeader($name)
    {
        throw new NotImplemented();
    }

    public function getBody(): PsrStream
    {
        throw new NotImplemented();
    }

    public function withBody(PsrStream $body)
    {
        throw new NotImplemented();
    }

    public function getRequestTarget()
    {
        throw new NotImplemented();
    }

    public function withRequestTarget($requestTarget)
    {
        throw new NotImplemented();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function withMethod($method)
    {
        throw new NotImplemented();
    }

    public function getUri(): PsrUri
    {
        throw new NotImplemented();
    }

    public function withUri(PsrUri $uri, $preserveHost = false)
    {
        throw new NotImplemented();
    }

    public function getServerParams()
    {
        throw new NotImplemented();
    }

    public function getCookieParams()
    {
        throw new NotImplemented();
    }

    public function withCookieParams(array $cookies)
    {
        throw new NotImplemented();
    }

    public function getQueryParams()
    {
        throw new NotImplemented();
    }

    public function withQueryParams(array $query)
    {
        throw new NotImplemented();
    }

    public function getUploadedFiles()
    {
        throw new NotImplemented();
    }

    public function withUploadedFiles(array $uploadedFiles)
    {
        throw new NotImplemented();
    }

    public function getParsedBody()
    {
        throw new NotImplemented();
    }

    public function withParsedBody($data)
    {
        throw new NotImplemented();
    }

    public function getAttributes()
    {
        throw new NotImplemented();
    }

    public function getAttribute($name, $default = null)
    {
        throw new NotImplemented();
    }

    public function withAttribute($name, $value)
    {
        throw new NotImplemented();
    }

    public function withoutAttribute($name)
    {
        throw new NotImplemented();
    }
}
