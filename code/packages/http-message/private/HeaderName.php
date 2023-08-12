<?php

namespace Bauhaus\Http\Message;

use Stringable;

final readonly class HeaderName implements Stringable
{
    private function __construct(
        private string $value,
    ) {
        // todo assert validity
    }

    public static function with(string $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function toNormalizedString(): string
    {
        return strtolower($this->value);
    }
}
