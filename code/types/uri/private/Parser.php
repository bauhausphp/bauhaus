<?php

namespace Bauhaus\Types\Uri;

final readonly class Parser
{
    private const SUCCESS = 1;

    private function __construct(
        /** @var Pattern[] */ private array $patterns,
    ) {
    }

    public static function with(Pattern ...$patterns): self
    {
        return new self($patterns);
    }

    public function parse(string $subject): array
    {
        $matches = $this->runPregMatch($subject);

        return array_filter($matches);
    }

    private function runPregMatch(string $subject): array
    {
        $matches = [];
        $pattern = $this->buildPattern();

        $result = preg_match($pattern, $subject, $matches);

        return $result === self::SUCCESS ? $matches : throw new InvalidUri($subject);
    }

    private function buildPattern(): string
    {
        return '%^(?J)(' . implode('|', $this->patterns) . ')$%i';
    }
}
