<?php

namespace Bauhaus\Http\Message\Request;

enum Method: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';

    public static function fromString(string $version): self
    {
        return self::tryFrom($version) ?? throw new InvalidMethod();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
