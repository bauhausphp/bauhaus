<?php

namespace Bauhaus\Http\Message\Response;

use InvalidArgumentException;

final class InvalidStatusCode extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid status code');
    }
}
