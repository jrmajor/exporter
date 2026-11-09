<?php

namespace Major\Exporter\Exporters;

/**
 * @template T of scalar
 */
abstract class ScalarExporter implements Exporter
{
    use Traits\IgnoresIndentation;
    use Traits\IsStringable;

    /**
     * @param T $value
     */
    final public function __construct(
        protected readonly mixed $value,
    ) { }
}
