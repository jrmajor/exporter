<?php

namespace Major\Exporter\Writers;

use Major\Exporter\Exporters\Exporter;
use Stringable;

abstract class Writer implements Stringable
{
    final public function __construct(
        protected readonly Exporter $value,
    ) { }
}
