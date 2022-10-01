<?php

namespace Bauhaus\Http\Message;

final class HeaderLine
{
    private readonly string $name;
    private readonly array $values;

    public function __construct(string $name, string ...$values)
    {
        $this->name = $name;
        $this->values = $values;
    }

    public function hasNameEqualTo(string $thatName): bool
    {
        return $this->name === $thatName;
    }

    public function hasValues(): bool
    {
        return [] !== $this->values;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function values(): array
    {
        return $this->values;
    }

    public function valuesToString(): string
    {
        return implode(', ', $this->values);
    }

    public function appendedWith(string ...$thatValues): self
    {
        return new self($this->name, ...$this->values, ...$thatValues);
    }
}
