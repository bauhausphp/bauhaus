<?php

namespace Bauhaus\Types\Uri;

final readonly class Chars
{
    private string $values;

    private function __construct(string ...$values)
    {
        $this->values = implode('', $values);
    }

    public static function with(self ...$chars): self
    {
        return new self(...$chars);
    }

    public static function digits(): self
    {
        return new self('\d');
    }

    public static function alpha(): self
    {
        return new self('a-z');
    }

    public static function colon(): self
    {
        return new self('\:');
    }

    public static function questionMark(): self
    {
        return new self('\?');
    }

    public static function slash(): self
    {
        return new self('\/');
    }

    public static function dash(): self
    {
        return new self('\-');
    }

    public static function dot(): self
    {
        return new self('\.');
    }

    public static function plus(): self
    {
        return new self('\+');
    }

    public static function unreserved(): self
    {
        return new self(self::alpha(), self::digits(), self::dash(), self::dot(), '\_\~');
    }

    public static function subdelims(): self
    {
        return new self('\!\$\&\'\(\)\*\+\,\;\=');
    }

    public static function pchar(): self
    {
        return new self(self::unreserved(), self::subdelims(), self::colon(), '\@');
    }

    public function __toString(): string
    {
        return $this->values;
    }
}
