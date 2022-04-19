<?php

namespace Major\Exporter;

final class Imports
{
    public function merge(self $imports): self
    {
        return new self();
    }

    public function isEmpty(): bool
    {
        return true;
    }
}
