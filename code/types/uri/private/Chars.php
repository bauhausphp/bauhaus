<?php

namespace types\type-uri\private;

final readonly class Chars
{
    private function __construct(
        private string $values,
    ) {
    }

    public function __toString(): string
    {
        return $this->values;
    }

    public static function digits(): self
    {
        return new self('\d');
    }

    public static function alpha(): self
    {
        return new self('a-zA-Z');
    }

    public static function colon(): self
    {
        return new self('\:');
    }

    public static function at(): self
    {
        return new self('\@');
    }

    public static function questionMark(): self
    {
        return new self('\?');
    }

    public static function slash(): self
    {
        return new self('\/');
    }

    public static function unreserved(): self
    {
        return new self(self::alpha() . self::digits() . '\-\.\_\~');
    }

    public static function subdelims(): self
    {
        return new self('\!\$\&\'\(\)\*\+\,\;\=');
    }

    public static function pchar(): self
    {
        return new self(self::unreserved() . self::subdelims() . self::colon() . self::at());
    }
}
