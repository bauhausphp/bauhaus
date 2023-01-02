<?php

namespace Bauhaus\Types\Uri\Patterns;

final class PortPattern extends PrimitivePattern
{
    protected function pattern(): string
    {
        return '[\d]*';
    }
}