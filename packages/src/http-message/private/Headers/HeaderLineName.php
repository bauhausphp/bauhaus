<?php

namespace Bauhaus\Http\Message\Headers;

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

    public function toLowerCaseString(): string
    {
        return strtolower($this->value);
    }
}
