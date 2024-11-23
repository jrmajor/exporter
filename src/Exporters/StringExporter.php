<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;
use Psl\Str;

/**
 * @extends ScalarExporter<string>
 */
final class StringExporter extends ScalarExporter
{
    private const array Escapes = [
        "\n" => '\\n', // line feed
        "\r" => '\\r', // carriage return
        "\t" => '\\t', // character tabulation
        "\u{A0}" => '\\u{A0}', // no break space
        "\u{061C}" => '\\u{061C}', // arabic letter mark
        "\u{2007}" => '\\u{2007}', // figure space
        "\u{200B}" => '\\u{200B}', // zero width space
        "\u{200E}" => '\\u{200E}', // left-to-right mark
        "\u{200F}" => '\\u{200F}', // right-to-left mark
        "\u{202F}" => '\\u{202F}', // narrow no break space
        "\u{2060}" => '\\u{2060}', // word joiner
    ];

    public function export(): Exported
    {
        $chars = mb_str_split($this->value);

        $types = ['single' => false, 'double' => false, 'escape' => false];

        /** @var array<int, 'single'|'double'|'dollar'|'slash'|'escape'> $escapes */
        $escapes = [];

        foreach ($chars as $index => $char) {
            $escape = match (true) {
                $char === "'" => 'single',
                $char === '"' => 'double',
                $char === '$' => 'dollar',
                $char === '\\' => 'slash',
                array_key_exists($char, self::Escapes) => 'escape',
                default => null,
            };

            if ($escape === null) {
                continue;
            }

            $types[$escape] = true;
            $escapes[$index] = $escape;
        }

        $quote = match (true) {
            $types['single'] && ! $types['double'],
            $types['escape'] => '"',
            default => "'",
        };

        foreach ($escapes as $index => $escape) {
            $chars[$index] = match ($escape) {
                'single' => $quote === "'" ? "\\'" : "'",
                'double' => $quote === '"' ? '\\"' : '"',
                'dollar' => $quote === '"' ? '\\$' : '$',
                'slash' => '\\\\',
                'escape' => self::Escapes[$chars[$index]],
            };
        }

        /** @var list<string> $chars */

        return new Exported($quote . Str\join($chars, '') . $quote);
    }
}
