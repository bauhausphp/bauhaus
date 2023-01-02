<?php

namespace Bauhaus\Tests\Types;

use Bauhaus\Types\InvalidUri;
use Bauhaus\Types\Uri;
use PHPUnit\Framework\TestCase;

class UriTest extends TestCase
{
    public function validUris(): iterable
    {
        yield 'scheme://host'
            => new Uri(scheme: 'scheme', host: 'host');
        yield 'scheme://user@host'
            => new Uri(scheme: 'scheme', user: 'user', host: 'host');
        yield 'scheme://user:password@host'
            => new Uri(scheme: 'scheme', user: 'user', password: 'password', host: 'host');
        yield 'scheme://user:password@host:666'
            => new Uri(scheme: 'scheme', user: 'user', password: 'password', host: 'host', port: 666);
        yield 'scheme://user:password@host:666/path'
            => new Uri(scheme: 'scheme', user: 'user', password: 'password', host: 'host', port: 666, path: '/path');
        yield 'scheme://user:password@host:666/path?query'
            => new Uri(scheme: 'scheme', user: 'user', password: 'password', host: 'host', port: 666, path: '/path', query: 'query');
        yield 'scheme://user:password@host:666/path?query#fragment'
            => new Uri(scheme: 'scheme', user: 'user', password: 'password', host: 'host', port: 666, path: '/path', query: 'query', fragment: 'fragment');

        yield 'scheme://host:666'
            => new Uri(scheme: 'scheme', host: 'host', port: 666);
        yield 'scheme://user:@host'
            => new Uri(scheme: 'scheme', user: 'user', host: 'host');
        yield 'scheme://user@host:666'
            => new Uri(scheme: 'scheme', user: 'user', host: 'host', port: 666);
        yield 'scheme://host/path'
            => new Uri(scheme: 'scheme', host: 'host', path: '/path');
        yield 'scheme://host:1234/path#fragment'
            => new Uri(scheme: 'scheme', host: 'host', port: 1234, path: '/path', fragment: 'fragment');
        yield 'scheme://host?query'
            => new Uri(scheme: 'scheme', host: 'host', query: 'query');
        yield 'scheme://host/?query'
            => new Uri(scheme: 'scheme', host: 'host', path: '/', query: 'query');

        yield 'scheme://host/super/path'
            => new Uri(scheme: 'scheme', host: 'host', path: '/super/path');
        yield 'scheme://host/super/super-path'
            => new Uri(scheme: 'scheme', host: 'host', path: '/super/super-path');
        yield 'scheme://host/super/super-path?q1=v1&q2=v2'
            => new Uri(scheme: 'scheme', host: 'host', path: '/super/super-path', query: 'q1=v1&q2=v2');
        yield 's3heme+ooo.666-123+ooo.111://host'
            => new Uri(scheme: 's3heme+ooo.666-123+ooo.111', host: 'host');
        yield "scheme://user-666._~!$&'()*+,;=:pass123:-666._~!$&'()*+,;=@host"
            => new Uri(scheme: 'scheme', user: "user-666._~!$&'()*+,;=", password: "pass123:-666._~!$&'()*+,;=", host: 'host');
        yield "scheme://host.com-666_~!$&'()*+,;=host"
            => new Uri(scheme: 'scheme', host: "host.com-666_~!$&'()*+,;=host");
        yield "scheme://host/path-666_~!$&'()*+,;=query:@/path"
            => new Uri(scheme: 'scheme', host: 'host', path: "/path-666_~!$&'()*+,;=query:@/path");
        yield "scheme://host?query-666_~!$&'()*+,;=query:@/?query"
            => new Uri(scheme: 'scheme', host: 'host', query: "query-666_~!$&'()*+,;=query:@/?query");
        yield "scheme://host#fragment-666_~!$&'()*+,;=query:@/?fragment"
            => new Uri(scheme: 'scheme', host: 'host', fragment: "fragment-666_~!$&'()*+,;=query:@/?fragment");

//        return [
//            'tel:+49666' => new Uri(scheme: 'tel', user: null, password: null, host: null, port: null, path: '+49666', query: [], fragment: null),
//        yield "http://www.ics.uci.edu/pub/ietf/uri/#Related"
//            => new Uri(scheme: 'http', host: 'www.ics.uci.edu', path: '/pub/ietf/uri/', fragment: 'Related');
    }

    public function validUrisDataProvider(): iterable
    {
        foreach ($this->validUris() as $uri => $expected) {
            yield $uri => [$expected, $uri];
        }
    }

    /**
     * @test
     * @dataProvider validUrisDataProvider
     */
    public function parseUriProperly(Uri $expected, string $uri): void
    {
        $uri = Uri::fromString($uri);

        self::assertEquals($expected, $uri);
    }

    public function invalidUris(): iterable
    {
        yield '1scheme://host';
        yield 'scheme~scheme://host';
//        yield '1tel:+49666';
//            'scheme://host:666asd',
    }

    public function invalidUrisDataProvider(): iterable
    {
        foreach ($this->invalidUris() as $uri) {
            yield $uri => [$uri];
        }
    }

    /**
     * @test
     * @dataProvider invalidUrisDataProvider
     */
    public function throwInvalidArgumentInvalidUriProvided(string $uri): void
    {
        self::expectException(InvalidUri::class);
        self::expectExceptionMessage("Invalid URI: $uri");

        Uri::fromString($uri);
    }
}
