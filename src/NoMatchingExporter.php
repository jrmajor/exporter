<?php

namespace Major\Exporter;

use Exception;

final class NoMatchingExporter extends Exception
{
    public function __construct(mixed $value)
    {
        $type = get_debug_type($value);

        parent::__construct("Could not find matching exporter for {$type}.");
    }
}
