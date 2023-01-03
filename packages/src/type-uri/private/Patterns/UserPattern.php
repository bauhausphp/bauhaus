<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Chars;

final class UserPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::unreserved() . Chars::subdelims();
    }
}
