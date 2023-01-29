<?php

namespace Bauhaus\Types\Uri\Patterns;

use Bauhaus\Types\Uri\Pattern;

abstract class PrimitivePattern implements Pattern
{
    public function __toString(): string
    {
        return $this->hasFistCharConstraint()
            ? "(?<{$this->name()}>[{$this->firstCharConstraint()}]{1}[{$this->chars()}]*)"
            : "(?<{$this->name()}>[{$this->chars()}]*)";
    }

    abstract protected function chars(): string;

    protected function firstCharConstraint(): ?string
    {
        return null;
    }

    private function hasFistCharConstraint(): bool
    {
        return null !== $this->firstCharConstraint();
    }

    private function name(): string
    {
        $name = explode('\\', static::class);
        $name = array_pop($name);
        $name = explode('Pattern', $name);

        return strtolower($name[0]);
    }
}
