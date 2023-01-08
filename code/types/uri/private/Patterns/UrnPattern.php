<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Pattern;

final class UrnPattern implements Pattern
{
    public function __toString(): string
    {
        $scheme = new SchemePattern();
        $path = new PathPattern();

        return "$scheme:(?!//)$path";
    }
}
