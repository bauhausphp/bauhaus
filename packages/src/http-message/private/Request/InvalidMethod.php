<?php

namespace Bauhaus\Http\Message\Request;

use InvalidArgumentException;

final class InvalidMethod extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid method');
    }
}
