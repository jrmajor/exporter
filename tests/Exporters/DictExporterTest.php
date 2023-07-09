<?php

namespace Major\Exporter\Tests\Exporters;

use Generator;
use Major\Exporter as E;
use Major\Exporter\Exporters;
use Major\Exporter\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Psl\Str;

final class DictExporterTest extends TestCase
{
    /**
     * @param array<Exporters\Exporter> $in
     */
    #[DataProvider('provideSinglelineCases')]
    public function testSinglelineWorks(string $out, array $in): void
    {
        $exported = (string) E\dict($in);

        $this->assertSame($out, $exported);
    }

    /**
     * @param array<Exporters\Exporter> $in
     */
    #[DataProvider('provideMultilineCases')]
    public function testMultilineWorks(string $out, array $in): void
    {
        $exported = (string) E\dict($in)->multiline();

        $this->assertSame($out, $exported);
    }

    /**
     * @return Generator<string, array{string, array<Exporters\Exporter>}>
     */
    public static function provideSinglelineCases(): Generator
    {
        yield 'short array' => [
            "['a' => 'a', 'b' => 1, 'c' => 2.3]",
            ['a' => E\string('a'), 'b' => E\int(1), 'c' => E\float(2.3)],
        ];
    }

    /**
     * @return Generator<string, array{string, array<Exporters\Exporter>}>
     */
    public static function provideMultilineCases(): Generator
    {
        yield 'long array' => [
            <<<'PHP'
                [
                    'first' => 'this is a long array',
                    'second' => 'it should be multiline',
                    'third' => 'foo bar baz',
                ]
                PHP,
            [
                'first' => E\string('this is a long array'),
                'second' => E\string('it should be multiline'),
                'third' => E\string('foo bar baz'),
            ],
        ];

        yield 'nested singleline lists' => [
            <<<'PHP'
                [
                    69 => [6, 9],
                    96 => [9, 6],
                ]
                PHP,
            [
                69 => E\vec([E\int(6), E\int(9)]),
                96 => E\vec([E\int(9), E\int(6)]),
            ],
        ];

        $long = Str\repeat('x', 20);

        yield 'nested multiline arrays' => [
            <<<PHP
                [
                    'test' => [
                        'a' => '{$long}',
                        'b' => '{$long}',
                    ],
                    'other' => [
                        'c' => '{$long}',
                        'd' => '{$long}',
                    ],
                ]
                PHP,
            [
                'test' => E\dict(['a' => E\string($long), 'b' => E\string($long)])->multiline(),
                'other' => E\dict(['c' => E\string($long), 'd' => E\string($long)])->multiline(),
            ],
        ];
    }
}
