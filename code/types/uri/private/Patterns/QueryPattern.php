<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Chars;

final class QueryPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::with(Chars::pchar(), Chars::questionMark(), Chars::slash());
    }
}
