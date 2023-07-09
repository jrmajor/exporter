<?php

namespace Major\Exporter\Tests\Exporters;

use Generator;
use Major\Exporter as E;
use Major\Exporter\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class StringExporterTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testItWorks(string $out, string $in): void
    {
        $exported = (string) E\string($in);

        $this->assertSame($out, $exported);
    }

    /**
     * @return Generator<string, array{string, string}>
     */
    public static function provideCases(): Generator
    {
        yield from [
            'no quotes' => ["'no quotes :)'", 'no quotes :)'],
            'double quotes' => ["'double: (\")'", 'double: (")'],
            'single quotes' => ['"single: (\')"', "single: (')"],
            'both quotes' => ["'both: (\") and (\\')'", 'both: (") and (\')'],
            'no quotes with slash' => ["'no quotes :\\\\'", 'no quotes :\\'],
            'double quotes with slash' => ["'double \\\\ (\")'", 'double \\ (")'],
            'single quotes with slash' => ['"single \\\\ (\')"', "single \\ (')"],
            'both quotes with slash' => ["'both: (\") \\\\ (\\')'", 'both: (") \\ (\')'],
            'dollar sign in single quotes' => ["'not a \$var'", 'not a $var'],
            'dollar sign in double quotes' => ['"not a \\$var\\n"', "not a \$var\n"],
            'tab and newline' => [
                '"some whitespace: (\\r\\n and \\t)"',
                "some whitespace: (\r\n and \t)",
            ],
            'non-printable' => [
                '"non-printable: (\\u{200B} and \\u{200E})"',
                "non-printable: (\u{200B} and \u{200E})",
            ],
        ];
    }
}
