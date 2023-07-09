<?php

namespace Major\Exporter\Exporters\Traits;

trait IgnoresIndentation
{
    /**
     * @param int<0, max> $n
     *
     * @return $this
     */
    final public function indent(int $n): self
    {
        return $this;
    }
}
