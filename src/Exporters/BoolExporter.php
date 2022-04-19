<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;

final class BoolExporter extends Exporter
{
    public function __construct(
        private readonly bool $value,
    ) { }

    public function export(): Exported
    {
        return new Exported($this->value ? 'true' : 'false');
    }
}
