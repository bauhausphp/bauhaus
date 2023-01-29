<?php

namespace Bauhaus\Http\Message;

use Stringable;

class Protocol implements Stringable
{
    private function __construct(
        private string $value,
    ) {
    }

    public static function version1dot1(): self
    {
        return new self('1.1');
    }

    public static function fromString(string $version): self
    {
        return match ($version) {
            '1.0', '1.1' => new self($version),
            default => throw new InvalidProtocol(),
        };
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
