<?php

namespace Bauhaus\Http\Message;

final class HeaderLineName
{
    private function __construct(
        private readonly string $value,
    ) {
        // todo assert validity
    }

    public static function fromInput(string $value): self
    {
        return new self($value);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function toNormalizedString(): string
    {
        return strtolower($this->value);
    }
}
