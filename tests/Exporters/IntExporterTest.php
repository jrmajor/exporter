<?php

namespace Major\Exporter\Tests\Exporters;

use Generator;
use Major\Exporter as E;
use Major\Exporter\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class IntExporterTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testItWorks(string $out, int $in): void
    {
        $exported = (string) E\int($in);

        $this->assertSame($out, $exported);
    }

    /**
     * @return Generator<string, array{string, int}>
     */
    public function provideCases(): Generator
    {
        yield from [
            'positive' => ['420', 420],
            'negative' => ['-69', -69],
        ];
    }
}
