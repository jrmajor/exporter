<?php

namespace Major\Exporter\Exporters\Traits;

trait MayBeMultiline
{
    protected bool $multiline = false;

    /**
     * @return $this
     */
    public function multiline(): self
    {
        $this->multiline = true;

        return $this;
    }
}
