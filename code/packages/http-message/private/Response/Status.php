<?php

namespace Bauhaus\Http\Message\Response;

use Stringable;

final readonly class Status implements Stringable
{
    private function __construct(
        private StatusCode $code,
        private StatusReasonPhrase $reasonPhrase,
    ) {
    }

    public static function with(int $code, string $reasonPhrase): self
    {
        $code = new StatusCode($code);
        $reasonPhrase = match ($reasonPhrase) {
            '' => StatusReasonPhrase::fromIanaRegistry($code),
            default => StatusReasonPhrase::custom($reasonPhrase),
        };

        return new self($code, $reasonPhrase);
    }

    public function __toString(): string
    {
        return "{$this->code()} {$this->reasonPhrase()}";
    }

    public function code(): int
    {
        return $this->code->toInt();
    }

    public function reasonPhrase(): string
    {
        return $this->reasonPhrase;
    }
}
