<?php

namespace Bauhaus\Http\Message\Response;

final class Status
{
    private readonly StatusCode $code;
    private readonly StatusReasonPhrase $reasonPhrase;

    public function __construct(int $code, string $reasonPhrase)
    {
        $this->code = new StatusCode($code);
        $this->reasonPhrase = '' === $reasonPhrase ?
            StatusReasonPhrase::fromIanaRegistry($this->code) :
            StatusReasonPhrase::custom($reasonPhrase);
    }

    public function code(): int
    {
        return $this->code->toInt();
    }

    public function reasonPhrase(): string
    {
        return $this->reasonPhrase->toString();
    }

    public function toString(): string
    {
        return "{$this->code()} {$this->reasonPhrase()}";
    }
}
