<?php

namespace Major\Exporter\Tests\Exporters;

use Generator;
use Major\Exporter as E;
use Major\Exporter\Exporters;
use Major\Exporter\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Psl\Str;

final class VecExporterTest extends TestCase
{
    /**
     * @param list<Exporters\Exporter> $in
     */
    #[DataProvider('provideSinglelineCases')]
    public function testSinglelineWorks(string $out, array $in): void
    {
        $exported = (string) E\vec($in);

        $this->assertSame($out, $exported);
    }

    /**
     * @param list<Exporters\Exporter> $in
     */
    #[DataProvider('provideMultilineCases')]
    public function testMultilineWorks(string $out, array $in): void
    {
        $exported = (string) E\vec($in)->multiline();

        $this->assertSame($out, $exported);
    }

    /**
     * @return Generator<string, array{string, list<Exporters\Exporter>}>
     */
    public static function provideSinglelineCases(): Generator
    {
        yield 'short list' => ["['a', 2.3]", [E\string('a'), E\float(2.3)]];
    }

    /**
     * @return Generator<string, array{string, list<Exporters\Exporter>}>
     */
    public static function provideMultilineCases(): Generator
    {
        yield 'long list' => [
            <<<'PHP'
                [
                    'this is a pretty long list',
                    'should be multiline',
                    "let's test some escapes:",
                    '\\r\\n\\t\'"\\u{200B}',
                    "\r\n\t'\"\\\u{200B}",
                ]
                PHP,
            [
                E\string('this is a pretty long list'),
                E\string('should be multiline'),
                E\string("let's test some escapes:"),
                E\string('\\r\\n\\t\'"\\u{200B}'),
                E\string("\r\n\t'\"\\\u{200B}"),
            ],
        ];

        yield 'nested singleline lists' => [
            <<<'PHP'
                [
                    ['a', 'b'],
                    ['c', 'd'],
                ]
                PHP,
            [
                E\vec([E\string('a'), E\string('b')]),
                E\vec([E\string('c'), E\string('d')]),
            ],
        ];

        $long = Str\repeat('x', 20);

        yield 'nested multiline lists' => [
            <<<PHP
                [
                    [
                        '{$long}',
                        '{$long}',
                    ],
                    [
                        '{$long}',
                        '{$long}',
                    ],
                ]
                PHP,
            [
                E\vec([E\string($long), E\string($long)])->multiline(),
                E\vec([E\string($long), E\string($long)])->multiline(),
            ],
        ];
    }
}
