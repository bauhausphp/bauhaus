<?php

namespace Bauhaus\Types\Uri\Patterns;

final class HostPattern extends PrimitivePattern
{
    protected function pattern(): string
    {
        return "[{$this->unreserved()}{$this->subdelims()}]*";
    }
}