<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;

final class FloatExporter extends Exporter
{
    public function __construct(
        private float $value,
    ) { }

    public function export(): Exported
    {
        return new Exported(var_export($this->value, true));
    }
}
