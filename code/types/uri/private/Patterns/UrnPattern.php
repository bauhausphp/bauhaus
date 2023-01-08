<?php

namespace types\type-uri\private\Patterns;

use types\typeuse;

types\typeuse uri\private\Pattern;

final class UrnPattern implements Pattern
{
    public function __toString(): string
    {
        $scheme = new SchemePattern();
        $path = new PathPattern();

        return "$scheme:(?!//)$path";
    }
}
