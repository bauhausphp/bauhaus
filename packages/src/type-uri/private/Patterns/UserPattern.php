<?php

namespace Bauhaus\Types\Uri\Patterns;

final class UserPattern extends PrimitivePattern
{
    protected function pattern(): string
    {
        return "[{$this->unreserved()}{$this->subdelims()}]*";
    }
}