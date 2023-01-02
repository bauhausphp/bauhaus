<?php

namespace Bauhaus\Types\Uri\Patterns;

final class PathPattern extends PrimitivePattern
{
    protected function pattern(): string
    {
        return "[{$this->pchar()}\/]*";
    }
}