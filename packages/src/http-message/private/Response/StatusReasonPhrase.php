<?php

namespace Bauhaus\Http\Message\Response;

final class StatusReasonPhrase
{
    private function __construct(
        private readonly string $value,
    ) {
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function custom(string $value): self
    {
        return new self($value);
    }

    public static function fromCode(StatusCode $code): self
    {
        return new self(match ($code->toInt()) {
            200 => 'Ok',
            404 => 'Not Found',
            default => '',
        });
    }
}
