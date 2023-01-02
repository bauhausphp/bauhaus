<?php

namespace Bauhaus\Types\Uri\Patterns;

final class FragmentPattern extends PrimitivePattern
{
    protected function pattern(): string
    {
        return "[{$this->pchar()}\/\?]*";
    }
}