<?php

namespace Bauhaus\Http;

use Bauhaus\Http\Message\ResponseStatus\Status;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Psr\Http\Message\StreamInterface as PsrStream;

final class Response implements PsrResponse
{
    private function __construct(
        private Status $status,
    ) {
    }

    public static function new(int $statusCode): self
    {
        return new self(new Status());
    }

    /** {@inheritdoc} */
    public function getProtocolVersion(): string
    {
    }

    /** {@inheritdoc} */
    public function getStatusCode(): int
    {
    }

    /** {@inheritdoc} */
    public function getReasonPhrase(): string
    {
    }

    /** {@inheritdoc} */
    public function getHeaders(): array
    {
    }

    /** {@inheritdoc} */
    public function getHeader($name): array
    {
    }

    /** {@inheritdoc} */
    public function getBody(): PsrStream
    {
    }

    /** {@inheritdoc} */
    public function hasHeader($name): bool
    {
    }

    /** {@inheritdoc} */
    public function getHeaderLine($name): string
    {
    }

    /** {@inheritdoc} */
    public function withProtocolVersion($version): PsrResponse
    {
    }

    /** {@inheritdoc} */
    public function withStatus($code, $reasonPhrase = ''): PsrResponse
    {
        return self::new($code);
    }

    /** {@inheritdoc} */
    public function withHeader($name, $value): PsrResponse
    {
    }

    /** {@inheritdoc} */
    public function withAddedHeader($name, $value): PsrResponse
    {
    }

    /** {@inheritdoc} */
    public function withoutHeader($name): PsrResponse
    {
    }

    /** {@inheritdoc} */
    public function withBody(PsrStream $body): PsrResponse
    {
    }
}
