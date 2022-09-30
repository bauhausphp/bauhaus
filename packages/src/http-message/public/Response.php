<?php

namespace Bauhaus\Http;

use Bauhaus\Http\Message\Protocol;
use Bauhaus\Http\Message\Response\Status;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Psr\Http\Message\StreamInterface as PsrStream;

final class Response implements PsrResponse
{
    public function __construct(
        private readonly Protocol $protocol,
        private readonly Status $status,
    ) {
    }

    /** {@inheritdoc} */
    public function getProtocolVersion(): string
    {
        return $this->protocol->toString();
    }

    /** {@inheritdoc} */
    public function getStatusCode(): int
    {
        return $this->status->code();
    }

    /** {@inheritdoc} */
    public function getReasonPhrase(): string
    {
        return $this->status->reasonPhrase();
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
        return $this->clonedWith(protocol: Protocol::fromString($version));
    }

    /** {@inheritdoc} */
    public function withStatus($code, $reasonPhrase = ''): PsrResponse
    {
        return $this->clonedWith(status: new Status($code, $reasonPhrase));
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

    private function clonedWith(
        Protocol $protocol = null,
        Status $status = null,
    ): self {
        return new self(
            $protocol ?? $this->protocol,
            $status ?? $this->status,
        );
    }
}
