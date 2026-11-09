<?php

namespace Major\Exporter;

final readonly class Exported
{
    public function __construct(
        public string $value,
        public Imports $imports = new Imports(),
    ) { }
}
