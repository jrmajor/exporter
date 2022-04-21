<?php

namespace Major\Exporter\Exporters\Traits;

use Major\Exporter\Writers\StringWriter;

trait IsStringable
{
    public function __toString(): string
    {
        return (string) new StringWriter($this);
    }
}
