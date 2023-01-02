<?php

namespace Bauhaus\Types\Uri\Patterns;

final class SchemePattern extends PrimitivePattern
{
    protected function pattern(): string
    {
        return '[a-z][a-z\d\.\-\+]*';
    }
}