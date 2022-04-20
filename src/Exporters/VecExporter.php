<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Imports;

/**
 * @extends ArrayExporter<list<Exporter>>
 */
final class VecExporter extends ArrayExporter
{
    /**
     * @return array{list<string>, Imports}
     */
    protected function values(): array
    {
        $values = [];
        $imports = new Imports();

        foreach ($this->value as $v) {
            $v = $v->indent($this->indentation(1))->export();

            $values[] = $v->value;
            $imports = $imports->merge($v->imports);
        }

        return [$values, $imports];
    }
}
