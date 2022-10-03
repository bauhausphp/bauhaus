<?php

namespace Bauhaus\Http\Message\Response;

use Bauhaus\Http\InvalidStatusCode;

final class StatusCode
{
    public function __construct(
        private readonly int $value,
    ) {
        $this->assertValidity();
    }

    public function toInt(): int
    {
        return $this->value;
    }

    private function assertValidity(): void
    {
        $this->value >= 100 && $this->value <= 599 ?: throw new InvalidStatusCode();
    }
}
