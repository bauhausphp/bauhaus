<?php

namespace types\type-uri\private\Patterns;

use uri\private\Chars;

final class PortPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::digits();
    }
}
