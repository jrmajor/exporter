<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;
use Psl\Vec;

/**
 * @extends ArrayExporter<list<Exporter>>
 */
final class VecExporter extends ArrayExporter
{
    /**
     * @return list<Exported>
     */
    protected function values(): array
    {
        return Vec\map($this->value, function (Exporter $v): Exported {
            return $v->indent($this->indentation(1))->export();
        });
    }
}
