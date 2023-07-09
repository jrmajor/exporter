<?php

namespace Major\Exporter\Exporters\Traits;

use Psl\Str;

trait HasIndentation
{
    /** @var int<0, max> */
    private int $indentation = 0;

    /**
     * @param int<0, max> $n
     *
     * @return $this
     */
    final public function indent(int $n): self
    {
        $this->indentation = $n;

        return $this;
    }

    /**
     * @param int<0, max> $add
     *
     * @return int<0, max>
     */
    final protected function indentation(int $add = 0): int
    {
        return $this->indentation + $add;
    }

    /**
     * @param int<0, max> $add
     */
    final protected function spaces(int $add = 0): string
    {
        return Str\repeat(' ', ($this->indentation + $add) * 4);
    }
}
