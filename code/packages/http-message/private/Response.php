<?php

namespace Bauhaus\Http\Message;

use Bauhaus\Http\Message\Response\Status;
use Psr\Http\Message\ResponseInterface as PsrResponse;
use Psr\Http\Message\StreamInterface as PsrStream;
use Stringable;

final readonly class Response implements PsrResponse, Stringable
{
    public function __construct(
        private Protocol $protocol,
        private Status $status,
        private Headers $headers,
        private PsrStream $body,
    ) {
    }

    public function __toString(): string
    {
        return <<<STR
            HTTP/{$this->protocol} {$this->status}
            {$this->headers}

            {$this->body}
            STR;
    }

    /** {@inheritdoc} */
    public function getProtocolVersion(): string
    {
        return $this->protocol;
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
        return $this->headers->find($name)->valuesAsArray();
    }

    /** {@inheritdoc} */
    public function getHeaderLine($name): string
    {
        return $this->headers->find($name)->valuesAsString();
    }

    /** {@inheritdoc} */
    public function getHeaders(): array
    {
        return $this->headers->toArray();
    }

    /** {@inheritdoc} */
    public function getBody(): PsrStream
    {
        return $this->body;
    }

    /** {@inheritdoc} */
    public function withProtocolVersion($version): PsrResponse
    {
        return $this->clonedWith(protocol: Protocol::fromString($version));
    }

    /** {@inheritdoc} */
    public function withStatus($code, $reasonPhrase = ''): PsrResponse
    {
        return $this->clonedWith(status: Status::with($code, $reasonPhrase));
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
        return $this->clonedWith(body: $body);
    }

    private function clonedWith(
        Protocol $protocol = null,
        Status $status = null,
        Headers $headers = null,
        PsrStream $body = null,
    ): self {
        return new self(
            $protocol ?? $this->protocol,
            $status ?? $this->status,
            $headers ?? $this->headers,
            $body ?? $this->body,
        );
    }
}
