<?php

namespace Major\Exporter\Writers;

use Major\Exporter\Exceptions\ExportedHasImports;
use Stringable;

final class StringWriter extends Writer implements Stringable
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
