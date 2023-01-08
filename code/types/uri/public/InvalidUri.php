<?php

namespace types\type-uri\public;

use InvalidArgumentException;

final class InvalidUri extends InvalidArgumentException
{
    public function __construct(string $subject)
    {
        parent::__construct("Invalid URI: $subject");
    }
}
