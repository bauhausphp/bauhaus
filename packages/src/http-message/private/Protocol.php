<?php

namespace Bauhaus\Http\Message;

use Bauhaus\Http\UnsupportedProtocol;

enum Protocol: string
{
    case V_1_0 = '1.0';
    case V_1_1 = '1.1';

    public static function fromString(string $version): self
    {
        return self::tryFrom($version) ?? throw new UnsupportedProtocol();
    }

    public function versionToString(): string
    {
        return $this->value;
    }

    public function toString(): string
    {
        return "HTTP/{$this->versionToString()}";
    }
}
