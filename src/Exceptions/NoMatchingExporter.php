<?php

namespace Major\Exporter\Exceptions;

use Exception;

final class NoMatchingExporter extends Exception
{
    public function __construct(mixed $value)
    {
        $type = get_debug_type($value);

        parent::__construct("Could not find matching exporter for {$type}.");
    }
}
