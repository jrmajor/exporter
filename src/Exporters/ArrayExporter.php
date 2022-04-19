<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;
use Major\Exporter\Imports;
use Psl\Str;

abstract class ArrayExporter extends Exporter
{
    use Traits\MayBeMultiline;

    public function export(): Exported
    {
        [$values, $imports] = $this->values();

        $value = $this->multiline
            ? $this->joinMultiline($values)
            : $this->joinSingleline($values);

        return new Exported($value, $imports);
    }

    /**
     * @return array{list<string>, Imports}
     */
    abstract protected function values(): array;

    /**
     * @param list<string> $values
     */
    private function joinSingleline(array $values): string
    {
        return '[' . Str\join($values, ', ') . ']';
    }

    /**
     * @param list<string> $values
     */
    private function joinMultiline(array $values): string
    {
        $content = Str\join($values, ",\n" . $this->spaces(1));

        return "[\n" . $this->spaces(1) . $content . ",\n" . $this->spaces() . ']';
    }
}
