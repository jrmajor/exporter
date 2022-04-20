<?php

namespace Major\Exporter\Writers;

use Major\Exporter\Exceptions\ExportedHasImports;

final class StringWriter extends Writer
{
    public function __toString(): string
    {
        $value = $this->value->export();

        if (! $value->imports->isEmpty()) {
            throw new ExportedHasImports();
        }

        return $value->value;
    }
}
