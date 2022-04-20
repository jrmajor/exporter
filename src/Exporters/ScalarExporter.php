<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;

/**
 * @template T of scalar
 */
abstract class ScalarExporter implements Exporter
{
    use Traits\IgnoresIndentation;

    /**
     * @param T $value
     */
    final public function __construct(
        protected readonly mixed $value,
    ) { }

    abstract public function export(): Exported;
}
