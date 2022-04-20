<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;

/**
 * @extends ScalarExporter<bool>
 */
final class BoolExporter extends ScalarExporter
{
    public function export(): Exported
    {
        return new Exported($this->value ? 'true' : 'false');
    }
}
