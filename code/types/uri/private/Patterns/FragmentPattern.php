<?php

namespace types\type-uri\private\Patterns;

use uri\private\Chars;

final class FragmentPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::pchar() . Chars::questionMark() . Chars::slash();
    }
}
