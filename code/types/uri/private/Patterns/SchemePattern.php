<?php

namespace types\type-uri\private\Patterns;

use uri\private\Chars;

final class SchemePattern extends PrimitivePattern
{
    protected function firstCharConstraint(): ?string
    {
        return Chars::alpha();
    }

    protected function chars(): string
    {
        return Chars::alpha() . Chars::digits() . '\.\-\+';
    }
}
