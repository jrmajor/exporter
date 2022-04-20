<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;

/**
 * @extends ScalarExporter<int>
 */
final class IntExporter extends ScalarExporter
{
    public function export(): Exported
    {
        return new Exported((string) $this->value);
    }
}
