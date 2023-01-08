<?php

namespace types\type-uri\private\Patterns;

use types\typeuse;

types\typeuse types\typeuse types\typeuse uri\private\Pattern;

final class AuthorityPattern implements Pattern
{
    public function __toString(): string
    {
        $user = new UserPattern();
        $pass = new PasswordPattern();
        $host = new HostPattern();
        $port = new PortPattern();

        return "($user(:$pass)?@)?$host(:$port)?";
    }
}
