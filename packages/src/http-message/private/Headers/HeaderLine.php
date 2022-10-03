<?php

namespace Bauhaus\Http\Message\Headers;

final class HeaderLine
{
    private function __construct(
        private readonly HeaderLineName $name,
        private readonly array $values,
    ) {
    }

    public static function fromInput(string $name, string ...$values): self
    {
        return new self(HeaderLineName::fromInput($name), $values);
    }

    public function hasValues(): bool
    {
        return [] !== $this->values;
    }

    public function name(): string
    {
        return $this->name->toString();
    }

    public function normalizedName(): string
    {
        return $this->name->toNormalizedString();
    }

    public function values(): array
    {
        return $this->values;
    }

    public function valuesToString(): string
    {
        return implode(', ', $this->values);
    }

    public function toString(): string
    {
        return "{$this->name()}: {$this->valuesToString()}";
    }

    public function appendedWith(string ...$thatValues): self
    {
        return new self($this->name, [...$this->values, ...$thatValues]);
    }
}
