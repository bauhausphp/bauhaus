<?php

namespace Bauhaus\Http;

use Bauhaus\Http\Message\Headers;
use Bauhaus\Http\Message\Protocol;
use Bauhaus\Http\Message\Response\Status;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Psr\Http\Message\StreamInterface as PsrStream;

final class Response implements PsrResponse
{
    public function __construct(
        private readonly Protocol $protocol,
        private readonly Status $status,
        private readonly Headers $headers,
    ) {
    }

    public function toString(): string
    {
        return <<<STR
            {$this->protocol->toString()} {$this->status->toString()}
            {$this->headers->toString()}

            {}
            STR;
    }

    /** {@inheritdoc} */
    public function getProtocolVersion(): string
    {
        return $this->protocol->versionToString();
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
    public function hasHeader($name): bool
    {
        return $this->headers->has($name);
    }

    /** {@inheritdoc} */
    public function getHeader($name): array
    {
        return $this->headers->find($name)->values();
    }

    /** {@inheritdoc} */
    public function getHeaderLine($name): string
    {
        return $this->headers->find($name)->valuesToString();
    }

    /** {@inheritdoc} */
    public function getHeaders(): array
    {
        return $this->headers->toArray();
    }

    /** {@inheritdoc} */
    public function getBody(): PsrStream
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
        return $this->clonedWith(status: Status::fromInput($code, $reasonPhrase));
    }

    /** {@inheritdoc} */
    public function withHeader($name, $value): PsrResponse
    {
        $values = is_array($value) ? $value : [$value];

        return $this->clonedWith(headers: $this->headers->overwrittenWith($name, ...$values));
    }

    /** {@inheritdoc} */
    public function withAddedHeader($name, $value): PsrResponse
    {
        $values = is_array($value) ? $value : [$value];

        return $this->clonedWith(headers: $this->headers->appendedWith($name, ...$values));
    }

    /** {@inheritdoc} */
    public function withoutHeader($name): PsrResponse
    {
        return $this->clonedWith(headers: $this->headers->without($name));
    }

    /** {@inheritdoc} */
    public function withBody(PsrStream $body): PsrResponse
    {
    }

    private function clonedWith(
        Protocol $protocol = null,
        Status $status = null,
        Headers $headers = null,
    ): self {
        return new self(
            $protocol ?? $this->protocol,
            $status ?? $this->status,
            $headers ?? $this->headers,
        );
    }
}
