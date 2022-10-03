<?php

namespace Bauhaus\Http\Message\Headers;

final class Headers
{
    /** @var HeaderLine[] */ private array $lines = [];

    private function __construct(HeaderLine ...$lines)
    {
        foreach ($lines as $line) {
            $this->lines[$line->normalizedName()] = $line;
        }

        ksort($this->lines);
    }

    public static function empty(): self
    {
        return new self();
    }

    public function toArray(): array
    {
        $arr = [];
        foreach ($this->lines as $line) {
            $arr[$line->name()] = $line->values();
        }

        return $arr;
    }

    public function toString(): string
    {
        return implode(
            "\n",
            array_map(fn (HeaderLine $l): string => $l->toString(), $this->lines),
        );
    }

    public function has(string $name): bool
    {
        return $this->find($name)->hasValues();
    }

    public function find(string $name): ?HeaderLine
    {
        $line = HeaderLine::fromInput($name);

        return $this->lines[$line->normalizedName()] ?? $line;
    }

    public function overwrittenWith(string $name, string ...$values): self
    {
        return $this
            ->without($name)
            ->with(HeaderLine::fromInput($name, ...$values));
    }

    public function appendedWith(string $name, string ...$values): self
    {
        return $this
            ->without($name)
            ->with($this->find($name)->appendedWith(...$values));
    }

    public function without(string $name): self
    {
        return new self(...array_diff_key($this->lines, $this->withOnly($name)->lines));
    }

    private function with(HeaderLine $newLine): self
    {
        return new self($newLine, ...$this->lines);
    }

    private function withOnly(string $name): self
    {
        return new self($this->find($name));
    }
}
