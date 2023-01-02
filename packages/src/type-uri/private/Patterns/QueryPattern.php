<?php

namespace Bauhaus\Types\Uri\Patterns;

final class QueryPattern extends PrimitivePattern
{
    protected function pattern(): string
    {
        return "[{$this->pchar()}\/\?]*";
    }
}