<?php

namespace Bauhaus\Http\Message;

final class Headers
{
    private readonly array $lines;

    private function __construct(HeaderLine ...$lines)
    {
        $this->lines = $lines;
    }

    public static function empty(): self
    {
        return new self();
    }

    public function has(string $name): bool
    {
        return $this->find($name)->hasValues();
    }

    public function find(string $name): ?HeaderLine
    {
        $filtered = $this->filter(fn (HeaderLine $l): bool => $l->hasNameEqualTo($name));

        return array_pop($filtered) ?? new HeaderLine($name);
    }

    public function toArray(): array
    {
        $arr = [];
        foreach ($this->lines as $l) {
            $arr[$l->name()] = $l->values();
        }

        return $arr;
    }

    public function overwrittenWith(string $name, string ...$values): self
    {
        return $this
            ->without($name)
            ->with(new HeaderLine($name, ...$values));
    }

    public function appendedWith(string $name, string ...$values): self
    {
        return $this
            ->without($name)
            ->with($this->find($name)->appendedWith(...$values));
    }

    public function without(string $name): self
    {
        return new self(...$this->filter(fn (HeaderLine $l): bool => !$l->hasNameEqualTo($name)));
    }

    private function with(HeaderLine $line): self
    {
        return new self($line, ...$this->lines);
    }

    private function filter(callable $filter): array
    {
        return array_filter($this->lines, $filter);
    }
}
