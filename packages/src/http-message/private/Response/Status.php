<?php

namespace Bauhaus\Http\Message\Response;

final class Status
{
    private function __construct(
        private readonly StatusCode $code,
        private readonly StatusReasonPhrase $reasonPhrase,
    ) {
    }

    public static function fromInput(int $code, string $reasonPhrase): self
    {
        $code = new StatusCode($code);
        $reasonPhrase = match ($reasonPhrase) {
            '' => StatusReasonPhrase::fromIanaRegistry($code),
            default => StatusReasonPhrase::custom($reasonPhrase),
        };

        return new self($code, $reasonPhrase);
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
