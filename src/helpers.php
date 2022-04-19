<?php

namespace Major\Exporter;

function to_string(Exporters\Exporter $value): string
{
    $value = $value->export();

    if (! $value->imports->isEmpty()) {
        throw new ExportedHasImports();
    }

    return $value->value;
}

function bool(bool $value): Exporters\BoolExporter
{
    return new Exporters\BoolExporter($value);
}
