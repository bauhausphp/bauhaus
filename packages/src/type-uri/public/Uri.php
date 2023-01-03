<?php

namespace Bauhaus\Types;

use Bauhaus\Types\Uri\Parser;
use Bauhaus\Types\Uri\Patterns\UriPattern;
use Bauhaus\Types\Uri\Patterns\UrnPattern;

/**
 * https://www.rfc-editor.org/rfc/rfc8820
 */
final readonly class Uri
{
    public function __construct(
        public string $scheme,
        public ?string $user = null,
        public ?string $password = null,
        public ?string $host = null,
        public ?int $port = null,
        public string $path = '',
        public ?string $query = null,
        public ?string $fragment = null,
    ) {
    }

    public static function fromString(string $subject): self
    {
        $parser = Parser::with(new UriPattern(), new UrnPattern());
        $parsed = $parser->parse($subject);

        return new self(
            scheme: $parsed['scheme'],
            user: $parsed['user'] ?? null,
            password: $parsed['password'] ?? null,
            host: $parsed['host'] ?? null,
            port: $parsed['port'] ?? null,
            path: $parsed['path'] ?? '',
            query: $parsed['query'] ?? null,
            fragment: $parsed['fragment'] ?? null,
        );
    }
}
