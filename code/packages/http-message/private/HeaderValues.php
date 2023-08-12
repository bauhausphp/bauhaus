<?php

namespace Bauhaus\Http\Message;

use Stringable;

final readonly class HeaderValues implements Stringable
{
    private function __construct(
        private array $values,
    ) {
    }

    public static function empty(): self
    {
        return new self([]);
    }

    public static function with(string $value, string ...$values): self
    {
        return new self([$value, ...$values]);
    }

    public function __toString(): string
    {
        return implode(', ', $this->values);
    }

    public function toArray(): array
    {
        return $this->values;
    }

    public function isEmpty(): bool
    {
        return [] === $this->values;
    }

    public function appendedWith(string ...$values): self
    {
        return new self([...$this->values, ...$values]);
    }
}
