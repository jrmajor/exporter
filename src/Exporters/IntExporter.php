<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;

final class IntExporter extends Exporter
{
    public function __construct(
        private int $value,
    ) { }

    public function export(): Exported
    {
        return new Exported((string) $this->value);
    }
}
