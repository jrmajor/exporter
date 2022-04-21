<?php

namespace Major\Exporter\Tests;

use Major\Exporter\Exported;
use Major\Exporter\Exporters\Exporter;
use Major\Exporter\Exporters\Traits\IgnoresIndentation;
use Major\Exporter\Exporters\Traits\IsStringable;
use Major\Exporter\Imports;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function mockExporter(
        string $value,
        Imports $imports = new Imports(),
    ): Exporter {
        return new class ($value, $imports) implements Exporter {
            use IgnoresIndentation;
            use IsStringable;

            public function __construct(
                private readonly string $value,
                private readonly Imports $imports,
            ) { }

            public function export(): Exported
            {
                return new Exported($this->value, $this->imports);
            }
        };
    }
}
