<?php

namespace Bauhaus\Http\Message;

use Stringable;

final readonly class HeaderLine implements Stringable
{
    private function __construct(
        private HeaderName $name,
        private HeaderValues $values,
    ) {
    }

    public static function empty(string $name): self
    {
        return new self(HeaderName::with($name), HeaderValues::empty());
    }

    public static function with(string $name, string ...$values): self
    {
        return new self(HeaderName::with($name), HeaderValues::with(...$values));
    }

    public function __toString(): string
    {
        return "{$this->name}: {$this->values}";
    }

    public function hasValues(): bool
    {
        return !$this->values->isEmpty();
    }

    public function id(): string
    {
        return $this->name->toNormalizedString();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function valuesAsArray(): array
    {
        return $this->values->toArray();
    }

    public function valuesAsString(): string
    {
        return $this->values;
    }

    public function appendedWith(string ...$values): self
    {
        return new self($this->name, $this->values->appendedWith(...$values));
    }
}
