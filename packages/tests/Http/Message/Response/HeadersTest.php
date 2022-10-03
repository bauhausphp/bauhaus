<?php

namespace Bauhaus\Tests\Http\Message\Response;

class HeadersTest extends TestCase
{
    private const CASE_INSENSITIVITY_SAMPLES = [
        ['sample', 'Sample'],
        ['sample', 'SAMPLE'],
        ['super-sample', 'Super-Sample'],
        ['super-sample', 'SUPER-SAMPLE'],
        ['another-super-sample', 'AnoTHER-supEr-SampLE'],
    ];

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveHeaderAfterAddingValues(string $case1, string $case2): void
    {
        $response = $this->response
            ->withHeader($case1, ['v1', 'v2']);

        $this->assertTrue($response->hasHeader($case2));
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveHeaderAfterAddingAndAppendingValues(string $case1, string $case2): void
    {
        $response = $this->response
            ->withHeader($case1, 'v1')
            ->withAddedHeader($case1, 'v2');

        $this->assertTrue($response->hasHeader($case2));
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function doNotHaveHeaderAfterRemovingIt(string $case1, string $case2): void
    {
        $response = $this->response
            ->withHeader($case1, 'v1')
            ->withAddedHeader($case1, 'v2')
            ->withoutHeader($case2);

        $this->assertFalse($response->hasHeader($case1));
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveValuesAsArrayEvenAfterAddingOnlyOne(string $case1, string $case2): void
    {
        $values = $this->response
            ->withHeader($case1, 'v1')
            ->getHeader($case2);

        $this->assertEquals(['v1'], $values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveValuesAsArrayAfterAddingMoreThanOne(string $case1, string $case2): void
    {
        $values = $this->response
            ->withHeader($case1, ['v1', 'v2'])
            ->getHeader($case2);

        $this->assertEquals(['v1', 'v2'], $values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveValuesAsArrayAfterAddingAndAppendingThem(string $case1, string $case2): void
    {
        $values = $this->response
            ->withHeader($case1, 'v1')
            ->withAddedHeader($case1, 'v2')
            ->getHeader($case2);

        $this->assertEquals(['v1', 'v2'], $values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function doNotHaveValueAsArrayAfterRemovingIt(string $case1, string $case2): void
    {
        $values = $this->response
            ->withHeader($case1, 'v1')
            ->withAddedHeader($case1, 'v2')
            ->withoutHeader($case2)
            ->getHeader($case1);

        $this->assertEmpty($values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnLineAsStringAfterAddingOneValue(string $case1, string $case2): void
    {
        $line = $this->response
            ->withHeader($case1, 'v1')
            ->getHeaderLine($case2);

        $this->assertEquals('v1', $line);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnLineStringAfterAddingMultipleValues(string $case1, string $case2): void
    {
        $line = $this->response
            ->withHeader($case1, ['v1', 'v2'])
            ->getHeaderLine($case2);

        $this->assertEquals('v1, v2', $line);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnLineAsStringAfterAddingAndAppendingMultipleValues(string $case1, string $case2): void
    {
        $line = $this->response
            ->withHeader($case1, ['v1', 'v2'])
            ->withAddedHeader($case1, ['v1', 'v2'])
            ->getHeaderLine($case2);

        $this->assertEquals('v1, v2, v1, v2', $line);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveEmptyLineAsStringAfterRemovingIt(string $case1, string $case2): void
    {
        $line = $this->response
            ->withHeader($case1, ['v1', 'v2'])
            ->withAddedHeader($case1, ['v1', 'v2'])
            ->withoutHeader($case2)
            ->getHeaderLine($case1);

        $this->assertEmpty($line);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function overwritePreviousValuesIfItAlreadyExists(string $case1, string $case2): void
    {
        $values = $this->response
            ->withHeader($case1, 'v1')
            ->withHeader($case2, 'v2')
            ->getHeader($case1);

        $this->assertEquals(['v2'], $values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function preserveOriginalCaseUsedToAddOrAppendValues(string $case1, string $case2): void
    {
        $headerXCase1 = "X-$case1";
        $headerXCase2 = "X-$case2";
        $headerYCase1 = "Y-$case1";
        $headerYCase2 = "Y-$case2";

        $allHeaders = $this->response
            ->withHeader($headerXCase1, 'v1')
            ->withHeader($headerYCase1, 'v2')
            ->withHeader($headerXCase1, ['v3', 'v4'])
            ->withAddedHeader($headerXCase2, 'v5')
            ->withoutHeader($headerYCase2)
            ->withAddedHeader($headerYCase2, ['v6', 'v7'])
            ->getHeaders();

        $this->assertEquals(
            [$headerXCase1 => ['v3', 'v4', 'v5'], $headerYCase2 => ['v6', 'v7']],
            $allHeaders,
        );
    }

    public function caseInsensitiveSamples(): \Generator
    {
        foreach (self::CASE_INSENSITIVITY_SAMPLES as $s) {
            $r = array_reverse($s);

            yield "{$s[0]}={$s[1]}" => $s;
            yield "{$r[0]}={$r[1]}" => $r;
        }
    }
}
