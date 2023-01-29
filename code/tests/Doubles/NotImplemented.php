<?php

namespace Bauhaus\Tests\Doubles;

use RuntimeException;

final class NotImplemented extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Not implemented');
    }
}
