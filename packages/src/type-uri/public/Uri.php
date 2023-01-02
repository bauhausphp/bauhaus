<?php

namespace Bauhaus\Types;

use Bauhaus\Types\Uri\Parser;
use Bauhaus\Types\Uri\Patterns\UriPattern;

// https://www.rfc-editor.org/rfc/rfc8820
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
        $parser = Parser::basedOn(new UriPattern());
        $parsed = $parser->parse($subject);

        return new self(
            scheme: $parsed['scheme'],
            user: $parsed['user'] ?? null,
            password: $parsed['password'] ?? null,
            host: $parsed['host'],
            port: $parsed['port'] ?? null,
            path: $parsed['path'] ?? '',
            query: $parsed['query'] ?? null,
            fragment: $parsed['fragment'] ?? null,
        );
    }
}