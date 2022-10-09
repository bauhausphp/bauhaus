<?php

namespace Bauhaus\Http\Message;

use InvalidArgumentException;

final class UnsupportedProtocol extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Unsupported protocol');
    }
}
