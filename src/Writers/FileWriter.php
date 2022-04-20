<?php

namespace Major\Exporter\Writers;

use Major\Exporter\Exporters\Exporter;
use Major\Exporter\Imports;
use Psl\Iter;
use Psl\Str;
use Psl\Vec;

final class FileWriter
{
    public function __construct(
        private readonly Exporter $value,
    ) { }

    public function __toString(): string
    {
        $value = $this->value->export();

        return Str\format(
            "<?php\n\n%sreturn %s;\n",
            $this->writeImports($value->imports),
            $value->value,
        );
    }

    private function writeImports(Imports $imports): string
    {
        $imports = $imports->optimized();

        return Iter\reduce_with_keys(
            [
                'use' => $imports->class,
                'use function' => $imports->func,
                'use const' => $imports->const,
            ],
            /**
             * @param list<string> $imports
             */
            function (string $acc, string $type, array $imports) {
                $imports = Vec\map($imports, fn (string $i): string => "{$type} {$i};");
                $imports = Str\join($imports, "\n");

                return $acc . ($imports !== '' ? "{$imports}\n\n" : '');
            },
            '',
        );
    }
}
