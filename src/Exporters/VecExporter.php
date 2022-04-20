<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Imports;

final class VecExporter extends ArrayExporter
{
    public function __construct(
        /** @var list<Exporter> */
        private readonly array $value,
    ) { }

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
