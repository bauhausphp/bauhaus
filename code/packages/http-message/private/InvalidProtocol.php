<?php

namespace Bauhaus\Http\Message;

use InvalidArgumentException;

final class InvalidProtocol extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Invalid protocol');
    }
}
