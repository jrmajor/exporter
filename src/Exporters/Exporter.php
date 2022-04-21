<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;
use Stringable;

interface Exporter extends Stringable
{
    public function export(): Exported;

    /**
     * @param int<0, max> $n
     * @return $this
     */
    public function indent(int $n): self;
}
