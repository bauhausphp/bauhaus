<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Pattern;

final class UriPattern implements Pattern
{
    public function __toString(): string
    {
        $scheme = new SchemePattern();
        $authority = new AuthorityPattern();
        $path = new PathPattern();
        $query = new QueryPattern();
        $fragment = new FragmentPattern();

        return "$scheme://$authority($path)?(\?$query)?(#$fragment)?";
    }
}