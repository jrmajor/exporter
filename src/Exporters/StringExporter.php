<?php

namespace Major\Exporter\Exporters;

use Major\Exporter\Exported;
use Psl\Str;
use Psl\Vec;

final class StringExporter extends Exporter
{
    private const ESCAPES = [
        "\n" => '\\n', // line feed
        "\r" => '\\r', // carriage return
        "\t" => '\\t', // character tabulation
        "\u{A0}" => '\\u{A0}', // no break space
        "\u{2007}" => '\\u{2007}', // figure space
        "\u{200B}" => '\\u{200B}', // zero width space
        "\u{200E}" => '\\u{200E}', // left-to-right mark
        "\u{200F}" => '\\u{200F}', // right-to-left mark
        "\u{202F}" => '\\u{202F}', // narrow no break space
        "\u{2060}" => '\\u{2060}', // word joiner
    ];

    public function __construct(
        private string $value,
    ) { }

    public function export(): Exported
    {
        $quote = $this->getCorrectQuote();

        $chars = Vec\map(
            Str\split($this->value, ''),
            fn (string $c): string => match (true) {
                $c === $quote => "\\{$c}",
                $c === '$' && $quote === '"' => '\\$',
                $c === '\\' => '\\\\',
                default => self::ESCAPES[$c] ?? $c,
            },
        );

        return new Exported($quote . Str\join($chars, '') . $quote);
    }

    private function getCorrectQuote(): string
    {
        if (
            Str\contains($this->value, "'")
            && ! Str\contains($this->value, '"')
        ) {
            return '"';
        }

        foreach (self::ESCAPES as $char => $_) {
            if (Str\contains($this->value, $char)) {
                return '"';
            }
        }

        return "'";
    }
}
