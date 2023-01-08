<?php

namespace types\type-uri\private\Patterns;

use uri\private\Chars;

final class PasswordPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::unreserved() . Chars::subdelims() . Chars::colon();
    }
}
