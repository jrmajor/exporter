<?php

namespace Major\Exporter;

use Closure;
use Major\Exporter\Exceptions\NoMatchingExporter;
use Psl\Dict;
use Psl\Iter;
use Psl\Type;

function to_string(Exporters\Exporter $value): string
{
    return (string) new Writers\StringWriter($value);
}

function to_file(Exporters\Exporter $value): string
{
    return (string) new Writers\FileWriter($value);
}

function guess(mixed $value): Exporters\Exporter
{
    if (is_array($value)) {
        $value = Dict\map($value, fn (mixed $v) => guess($v));

        /** @psalm-suppress MixedArgumentTypeCoercion */
        return array_is_list($value) ? vec($value) : dict($value);
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

/**
 * @template Tk of array-key
 *
 * @param array<Tk, Exporters\Exporter> $value
 * @param ?Closure(Tk): Exporters\Exporter $keyExporter
 * @return Exporters\DictExporter<Tk>
 */
function dict(array $value, ?Closure $keyExporter = null): Exporters\DictExporter
{
    return new Exporters\DictExporter($value, $keyExporter ?? guess(...));
}

/**
 * @param list<string|Exported> $values
 */
function join(array $values, string $glue = ''): Exported
{
    $first = true;

    $reducer = function (
        Exported $acc, string|Exported $value,
    ) use ($glue, &$first): Exported {
        [$g, $first] = [$first ? '' : $glue, false];

        if (Type\string()->matches($value)) {
            return new Exported($acc->value . $g . $value, $acc->imports);
        }

        return new Exported(
            $acc->value . $g . $value->value,
            $acc->imports->merge($value->imports),
        );
    };

    return Iter\reduce($values, $reducer, new Exported(''));
}
