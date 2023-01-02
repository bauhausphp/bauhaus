<?php

namespace Bauhaus\Types\Uri\Patterns;

final class PasswordPattern extends PrimitivePattern
{
    protected function pattern(): string
    {
        return "[{$this->unreserved()}{$this->subdelims()}\:]*";
    }
}