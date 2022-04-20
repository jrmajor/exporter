<?php

namespace Major\Exporter\Tests;

use DateTime;
use Generator;
use Major\Exporter as E;
use Major\Exporter\Exceptions\NoMatchingExporter;
use Major\Exporter\Exporters;
use PHPUnit\Framework\Attributes\DataProvider;

final class GuesserTest extends TestCase
{
    /**
     * @param class-string<Exporters\Exporter> $class
     */
    #[DataProvider('provideCases')]
    public function testItWorks(string $class, mixed $value): void
    {
        $this->assertInstanceOf($class, E\guess($value));
    }

    public function testItThrows(): void
    {
        $this->expectException(NoMatchingExporter::class);
        $this->expectExceptionMessage('Could not find matching exporter for DateTime.');

        E\guess(new DateTime());
    }

    /**
     * @return Generator<string, array{class-string<Exporters\Exporter>, mixed}>
     */
    public function provideCases(): Generator
    {
        yield from [
            'bool' => [Exporters\BoolExporter::class, true],
            'int' => [Exporters\IntExporter::class, 19],
            'float' => [Exporters\FloatExporter::class, 4.5],
            'string' => [Exporters\StringExporter::class, 'foo'],
            'vec' => [Exporters\VecExporter::class, []],
        ];
    }
}
