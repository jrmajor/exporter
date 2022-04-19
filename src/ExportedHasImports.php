<?php

namespace Major\Exporter;

use Exception;

final class ExportedHasImports extends Exception
{
    public function __construct()
    {
        parent::__construct('Exported value has imports, can not write it to string.');
    }
}
