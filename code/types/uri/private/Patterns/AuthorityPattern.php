<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Pattern;

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
