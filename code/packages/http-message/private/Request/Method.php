<?php

namespace Bauhaus\Http\Message\Request;

use Stringable;

final readonly class Method implements Stringable
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function fromString(string $value): self
    {
        return match ($value) {
            'GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE' => new self($value),
            default => throw new InvalidMethod(),
        };

    }

    public function __toString(): string
    {
        return $this->value;
    }
}
