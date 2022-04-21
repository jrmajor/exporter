<?php

namespace Major\Exporter\Exporters;

use Major\Exporter as E;
use Major\Exporter\Exported;

abstract class ArrayExporter implements Exporter
{
    use Traits\HasIndentation;
    use Traits\IsStringable;
    use Traits\MayBeMultiline;

    public function export(): Exported
    {
        return $this->multiline
            ? $this->joinMultiline()
            : $this->joinSingleline();
    }

    /**
     * @return list<Exported>
     */
    abstract protected function values(): array;

    private function joinSingleline(): Exported
    {
        return E\join(['[', E\join($this->values(), ', '), ']']);
    }

    private function joinMultiline(): Exported
    {
        $content = E\join($this->values(), ",\n" . $this->spaces(1));

        return E\join(["[\n" . $this->spaces(1), $content, ",\n" . $this->spaces() . ']']);
    }
}
