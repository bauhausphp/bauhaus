<?php

namespace Bauhaus\Tests\Http\Message;

use Generator;

// TODO validate name and values
abstract class HttpMessageHeadersTestCase extends HttpMessageTestCase
{
    private const CASE_INSENSITIVITY_SAMPLES = [
        ['sample', 'Sample'],
        ['sample', 'SAMPLE'],
        ['super-sample', 'Super-Sample'],
        ['super-sample', 'SUPER-SAMPLE'],
        ['another-super-sample', 'AnoTHER-supEr-SampLE'],
    ];

    public function caseInsensitiveSamples(): Generator
    {
        foreach (self::CASE_INSENSITIVITY_SAMPLES as $sample) {
            $reversedSample = array_reverse($sample);
            yield "{$sample[0]}={$sample[1]}" => $sample;
            yield "{$reversedSample[0]}={$reversedSample[1]}" => $reversedSample;
        }
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveHeaderAfterAddingHeaderValues(string $case1, string $case2): void
    {
        $message = $this->message->withHeader($case1, ['v1', 'v2']);

        self::assertTrue($message->hasHeader($case2));
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveHeaderAfterAppendingHeaderValues(string $case1, string $case2): void
    {
        $message = $this->message->withAddedHeader($case1, 'v2');

        self::assertTrue($message->hasHeader($case2));
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveHeaderAfterAddingAndAppendingHeaderValues(string $case1, string $case2): void
    {
        $message = $this->message
            ->withHeader($case1, 'v1')
            ->withAddedHeader($case1, 'v2');

        self::assertTrue($message->hasHeader($case2));
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function doNotHaveHeaderAfterRemovingIt(string $case1, string $case2): void
    {
        $message = $this->message
            ->withHeader($case1, 'v1')
            ->withAddedHeader($case1, 'v2')
            ->withoutHeader($case2);

        self::assertFalse($message->hasHeader($case1));
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnHeaderValueAsArrayEvenIfOnlyOneWasAdded(string $case1, string $case2): void
    {
        $values = $this->message
            ->withHeader($case1, 'v1')
            ->getHeader($case2);

        self::assertEquals(['v1'], $values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnHeaderValuesAsArrayAfterAddingThem(string $case1, string $case2): void
    {
        $values = $this->message
            ->withHeader($case1, ['v1', 'v2'])
            ->getHeader($case2);

        self::assertEquals(['v1', 'v2'], $values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnHeaderValuesAsArrayAfterAddingAndAppendingThem(string $case1, string $case2): void
    {
        $values = $this->message
            ->withHeader($case1, 'v1')
            ->withAddedHeader($case1, 'v2')
            ->getHeader($case2);

        self::assertEquals(['v1', 'v2'], $values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function doNotHaveValuesAfterHeaderRemoval(string $case1, string $case2): void
    {
        $values = $this->message
            ->withHeader($case1, 'v1')
            ->withAddedHeader($case1, 'v2')
            ->withoutHeader($case2)
            ->getHeader($case1);

        self::assertEmpty($values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnHeaderLineAsStringAfterAddingOneValue(string $case1, string $case2): void
    {
        $line = $this->message
            ->withHeader($case1, 'v1')
            ->getHeaderLine($case2);

        self::assertEquals('v1', $line);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnHeaderLineStringAfterAddingMultipleValues(string $case1, string $case2): void
    {
        $line = $this->message
            ->withHeader($case1, ['v1', 'v2'])
            ->getHeaderLine($case2);

        $this->assertEquals('v1, v2', $line);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function returnHeaderLineAsStringAfterAddingAndAppendingMultipleValues(string $case1, string $case2): void
    {
        $line = $this->message
            ->withHeader($case1, ['v1', 'v2'])
            ->withAddedHeader($case1, ['v1', 'v2'])
            ->getHeaderLine($case2);

        self::assertEquals('v1, v2, v1, v2', $line);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function haveEmptyLineAfterHeaderRemoval(string $case1, string $case2): void
    {
        $line = $this->message
            ->withHeader($case1, ['v1', 'v2'])
            ->withAddedHeader($case1, ['v1', 'v2'])
            ->withoutHeader($case2)
            ->getHeaderLine($case1);

        self::assertEmpty($line);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function overwritePreviousHeaderValuesIfItAlreadyExists(string $case1, string $case2): void
    {
        $values = $this->message
            ->withHeader($case1, 'v1')
            ->withHeader($case2, 'v2')
            ->withHeader($case1, 'v3')
            ->withHeader($case2, 'v4')
            ->getHeader($case1);

        self::assertEquals(['v4'], $values);
    }

    /** @test @dataProvider caseInsensitiveSamples */
    public function preserveOriginalNameCaseUsedToAddOrHeaderAppendValues(string $case1, string $case2): void
    {
        $aHeaderCase1 = "A-$case1";
        $aHeaderCase2 = "a-$case2";
        $anotherHeaderCase1 = "Another-$case1";
        $anotherHeaderCase2 = "aNother-$case2";

        $allHeaders = $this->message
            ->withHeader($aHeaderCase1, 'v1')
            ->withHeader($anotherHeaderCase1, 'v2')
            ->withHeader($aHeaderCase1, ['v3', 'v4'])
            ->withAddedHeader($aHeaderCase2, 'v5')
            ->withoutHeader($anotherHeaderCase2)
            ->withAddedHeader($anotherHeaderCase2, ['v6', 'v7'])
            ->getHeaders();

        self::assertEquals(
            [$aHeaderCase1 => ['v3', 'v4', 'v5'], $anotherHeaderCase2 => ['v6', 'v7']],
            $allHeaders,
        );
    }
}
