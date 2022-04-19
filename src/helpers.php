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

function guess(mixed $value): Exporters\Exporter
{
    if (is_array($value) && array_is_list($value)) {
        return vec(array_map(fn (mixed $v) => guess($v), $value));
    }

    return match (true) {
        is_bool($value) => bool($value),
        is_int($value) => int($value),
        is_float($value) => float($value),
        is_string($value) => string($value),
        default => throw new NoMatchingExporter($value),
    };
}

function bool(bool $value): Exporters\BoolExporter
{
    return new Exporters\BoolExporter($value);
}

function int(int $value): Exporters\IntExporter
{
    return new Exporters\IntExporter($value);
}

function float(float $value): Exporters\FloatExporter
{
    return new Exporters\FloatExporter($value);
}

function string(string $value): Exporters\StringExporter
{
    return new Exporters\StringExporter($value);
}

/**
 * @param list<Exporters\Exporter> $value
 */
function vec(array $value): Exporters\VecExporter
{
    return new Exporters\VecExporter($value);
}
