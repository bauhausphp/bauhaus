<?php

namespace types\type-uri\private\Patterns;

use uri\private\Chars;

final class HostPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::unreserved() . Chars::subdelims();
    }
}
