<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Pattern;

abstract class PrimitivePattern implements Pattern
{
    public function __toString(): string
    {
        return "(?<{$this->name()}>{$this->pattern()})";
    }

    private function name(): string
    {
        $name = explode('\\', static::class);
        $name = array_pop($name);
        $name = explode('Pattern', $name);

        return strtolower($name[0]);
    }

    abstract protected function pattern(): string;

    protected function unreserved(): string
    {
        return 'a-z\d\-\.\_\~';
    }

    protected function subdelims(): string
    {
        return '\!\$\&\'\(\)\*\+\,\;\=';
    }

    protected function pchar(): string
    {
        return "{$this->unreserved()}{$this->subdelims()}\:\@";
    }
}