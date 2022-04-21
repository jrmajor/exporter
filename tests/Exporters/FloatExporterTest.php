<?php

namespace Major\Exporter\Tests\Exporters;

use Generator;
use Major\Exporter as E;
use Major\Exporter\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class FloatExporterTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testItWorks(string $out, float $in): void
    {
        $exported = (string) E\float($in);

        $this->assertSame($out, $exported);
    }

    /**
     * @return Generator<string, array{string, float}>
     */
    public function provideCases(): Generator
    {
        yield from [
            'positive' => ['6.9', 6.9],
            'negative' => ['-12.34', -12.34],
            'with zero' => ['10.0', 10.0],
        ];
    }
}
