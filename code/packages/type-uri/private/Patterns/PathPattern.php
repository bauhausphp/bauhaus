<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Chars;

final class PathPattern extends PrimitivePattern
{
    private bool $startingWithSlash = false;

    public static function startingWithSlash(): self
    {
        $self = new self();
        $self->startingWithSlash = true;

        return $self;
    }

    protected function firstCharConstraint(): ?string
    {
        return $this->startingWithSlash ? Chars::slash() : null;
    }

    protected function chars(): string
    {
        return Chars::with(Chars::pchar(), Chars::slash());
    }
}
