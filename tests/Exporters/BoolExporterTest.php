<?php

namespace Major\Exporter\Tests\Exporters;

use Generator;
use Major\Exporter as E;
use Major\Exporter\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class BoolExporterTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testItWorks(string $out, bool $in): void
    {
        $exported = (string) E\bool($in);

        $this->assertSame($out, $exported);
    }

    /**
     * @return Generator<string, array{string, bool}>
     */
    public static function provideCases(): Generator
    {
        yield from [
            'true' => ['true', true],
            'false' => ['false', false],
        ];
    }
}
