<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;

/**
 * @extends ScalarExporter<float>
 */
final class FloatExporter extends ScalarExporter
{
    public function export(): Exported
    {
        return new Exported(var_export($this->value, true));
    }
}
