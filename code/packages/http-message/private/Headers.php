<?php

namespace Bauhaus\Http\Message;

use Stringable;

final class Headers implements Stringable
{
    /** @var HeaderLine[] */ private array $lines = [];

    private function __construct(HeaderLine ...$lines)
    {
        foreach ($lines as $line) {
            $this->lines[$line->id()] = $line;
        }

        ksort($this->lines);
    }

    public static function empty(): self
    {
        return new self();
    }

    public function __toString(): string
    {
        return implode("\n", $this->lines);
    }

    public function toArray(): array
    {
        $arr = [];
        foreach ($this->lines as $line) {
            $arr[$line->name()] = $line->valuesAsArray();
        }

        return $arr;
    }

    public function has(string $name): bool
    {
        return $this->find($name)->hasValues();
    }

    public function find(string $name): HeaderLine
    {
        $line = HeaderLine::empty($name);

        return $this->lines[$line->id()] ?? $line;
    }

    public function overwrittenWith(string $name, string ...$values): self
    {
        return $this
            ->without($name)
            ->with(HeaderLine::with($name, ...$values));
    }

    public function appendedWith(string $name, string ...$values): self
    {
        return $this
            ->without($name)
            ->with($this->find($name)->appendedWith(...$values));
    }

    public function without(string $name): self
    {
        $linesWithout = $this->lines;
        unset($linesWithout[HeaderLine::empty($name)->id()]);

        return new self(...$linesWithout);
    }

    private function with(HeaderLine $newLine): self
    {
        return new self($newLine, ...$this->lines);
    }
}
