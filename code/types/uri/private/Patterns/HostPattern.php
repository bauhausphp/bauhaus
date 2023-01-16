<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Chars;

final class HostPattern extends PrimitivePattern
{
    protected function chars(): string
    {
        return Chars::with(Chars::unreserved(), Chars::subdelims());
    }
}
