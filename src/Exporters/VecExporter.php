<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;
use Psl\Vec;

final class VecExporter extends ArrayExporter
{
    public function __construct(
        /** @var list<Exporter> */
        private readonly array $value,
    ) { }

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
