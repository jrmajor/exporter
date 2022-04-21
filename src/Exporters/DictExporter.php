<?php

namespace Major\Exporter\Exporters;

use Closure;
use Major\Exporter as E;
use Major\Exporter\Exported;
use Psl\Vec;

/**
 * @template Tk of array-key
 */
final class DictExporter extends ArrayExporter
{
    /**
     * @param array<Tk, Exporter> $value
     * @param Closure(Tk): Exporter $keyExporter
     */
    public function __construct(
        private readonly array $value,
        private readonly Closure $keyExporter,
    ) { }

    /**
     * @return list<Exported>
     */
    protected function values(): array
    {
        return Vec\map_with_key(
            $this->value,
            fn (mixed $k, Exporter $v): Exported => E\join([
                ($this->keyExporter)($k)->indent($this->indentation(1))->export(),
                ' => ',
                $v->indent($this->indentation(1))->export(),
            ]),
        );
    }
}
