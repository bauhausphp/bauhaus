<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Chars;

final class SchemePattern extends PrimitivePattern
{
    protected function firstCharConstraint(): ?string
    {
        return Chars::alpha();
    }

    protected function chars(): string
    {
        return Chars::with(Chars::alpha(), Chars::digits(), Chars::dot(), Chars::dash(), Chars::plus());
    }
}
