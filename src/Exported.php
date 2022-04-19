<?php

namespace Major\Exporter;

final class Exported
{
    public function __construct(
        public readonly string $value,
        public readonly Imports $imports = new Imports(),
    ) { }
}
