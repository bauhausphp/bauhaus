<?php

namespace Bauhaus\Tests\Types;

use Bauhaus\ServiceResolverSettings;
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
            => new Uri(
                scheme: 'scheme',
                user: 'user',
                password: 'password',
                host: 'host',
                port: 666,
                path: '/path',
                query: 'query',
            );
        yield 'scheme://user:password@host:666/path?query#fragment'
            => new Uri(
                scheme: 'scheme',
                user: 'user',
                password: 'password',
                host: 'host',
                port: 666,
                path: '/path',
                query: 'query',
                fragment: 'fragment',
            );

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
        yield "scheme://user-666._~!$&'()*+,;=@host"
        => new Uri(scheme: 'scheme', user: "user-666._~!$&'()*+,;=", host: 'host');
        yield "scheme://user:pass123:-666._~!$&'()*+,;=@host"
            => new Uri(scheme: 'scheme', user: 'user', password: "pass123:-666._~!$&'()*+,;=", host: 'host');
        yield "scheme://host.com-666_~!$&'()*+,;=host"
            => new Uri(scheme: 'scheme', host: "host.com-666_~!$&'()*+,;=host");
        yield "scheme://host/path-666_~!$&'()*+,;=query:@/path"
            => new Uri(scheme: 'scheme', host: 'host', path: "/path-666_~!$&'()*+,;=query:@/path");
        yield "scheme://host?query-666_~!$&'()*+,;=query:@/?query"
            => new Uri(scheme: 'scheme', host: 'host', query: "query-666_~!$&'()*+,;=query:@/?query");
        yield "scheme://host#fragment-666_~!$&'()*+,;=query:@/?fragment"
            => new Uri(scheme: 'scheme', host: 'host', fragment: "fragment-666_~!$&'()*+,;=query:@/?fragment");

        yield 'http://127.0.0.1'
            => new Uri(scheme: 'http', host: '127.0.0.1');
        yield 'HTTP://www.ics.uci.edu/pub/ietf/uri/#Related'
            => new Uri(scheme: 'HTTP', host: 'www.ics.uci.edu', path: '/pub/ietf/uri/', fragment: 'Related');
        yield 'ftp://ftp.is.co.za/rfc/rfc1808.txt'
            => new Uri(scheme: 'ftp', host: 'ftp.is.co.za', path: '/rfc/rfc1808.txt');
        yield 'http://www.ietf.org/rfc/rfc2396.txt'
            => new Uri(scheme: 'http', host: 'www.ietf.org', path: '/rfc/rfc2396.txt');
        yield 'telnet://192.0.2.16:80/'
            => new Uri(scheme: 'telnet', host: '192.0.2.16', port:80, path: '/');

        yield 'mailto:John.Doe@example.com'
            => new Uri(scheme: 'mailto', path: 'John.Doe@example.com');
        yield 'news:comp.infosystems.www.servers.unix'
            => new Uri(scheme: 'news', path: 'comp.infosystems.www.servers.unix');
        yield 'tel:+1-816-555-1212'
            => new Uri(scheme: 'tel', path: '+1-816-555-1212');
        yield 'urn:oasis:names:specification:docbook:dtd:xml:4.1.2'
            => new Uri(scheme: 'urn', path: 'oasis:names:specification:docbook:dtd:xml:4.1.2');
    }

    public function validUrisDataProvider(): iterable
    {
        foreach ($this->validUris() as $uri => $expected) {
            yield $uri => [$uri, $expected];
        }
    }

    /**
     * @test
     * @dataProvider validUrisDataProvider
     */
    public function parseUriProperly(string $uri, Uri $expected): void
    {
        ServiceResolverSettings::new()->withServices([]);
        $uri = Uri::fromString($uri);

        self::assertEquals($expected, $uri);
    }

    public function invalidUris(): iterable
    {
        yield '1scheme://host';
        yield 'scheme~scheme://host';
        yield 'scheme://host:666asd';
        yield 'scheme://host:666//asd';
        yield '1tel:+49666';
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
