<?php

namespace types\type-uri\private\Patterns;

use types\typeuse;

types\typeuse types\typeuse types\typeuse uri\private\Pattern;

final class UriPattern implements Pattern
{
    public function __toString(): string
    {
        $scheme = new SchemePattern();
        $authority = new AuthorityPattern();
        $path = PathPattern::startingWithSlash();
        $query = new QueryPattern();
        $fragment = new FragmentPattern();

        return "$scheme://$authority(?!//)($path)?(\?$query)?(#$fragment)?";
    }
}
