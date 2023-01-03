<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Chars;

final class PortPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::digits();
    }
}
