<?php

namespace Bauhaus\Types\Uri;

use Bauhaus\Types\InvalidUri;

final readonly class Parser
{
    private const SUCCESS = 1;

    private function __construct(
        private Pattern $pattern,
    ) {
    }

    public static function basedOn(Pattern $pattern): self
    {
        return new self($pattern);
    }

    public function parse(string $subject): array
    {
        $matches = $this->runPregMatch($subject);

        return array_filter($matches);
    }

    private function runPregMatch(string $subject): array
    {
        $matches = [];
        $result = preg_match("%^{$this->pattern}$%", $subject, $matches);

        return $result === self::SUCCESS ? $matches : throw new InvalidUri($subject);
    }
}