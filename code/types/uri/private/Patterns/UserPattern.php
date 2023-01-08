<?php

namespace types\type-uri\private\Patterns;

use uri\private\Chars;

final class UserPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::unreserved() . Chars::subdelims();
    }
}
