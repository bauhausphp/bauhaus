<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Chars;

final class PasswordPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::with(Chars::unreserved(), Chars::subdelims(), Chars::colon());
    }
}
