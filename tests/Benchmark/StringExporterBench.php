<?php

namespace Major\Exporter\Tests\Benchmark;

use Major\Exporter as E;
use PhpBench\Attributes\BeforeMethods;
use PhpBench\Attributes\Iterations;
use PhpBench\Attributes\Revs;
use Psl\Str;

#[BeforeMethods('setUp')]
final class StringExporterBench
{
    private string $long;

    public function setUp(): void
    {
        $this->long = Str\repeat('x', 256);
    }

    #[Revs(50), Iterations(10)]
    public function benchShortStringSimple(): void
    {
        (string) E\string('short string — simple');
    }

    #[Revs(50), Iterations(10)]
    public function benchShortStringQuote(): void
    {
        (string) E\string("short string ' quote");
    }

    #[Revs(50), Iterations(10)]
    public function benchShortStringEscape(): void
    {
        (string) E\string("short string \n escape");
    }

    #[Revs(20), Iterations(10)]
    public function benchLongStringSimple(): void
    {
        (string) E\string("{$this->long} string — simple");
    }

    #[Revs(20), Iterations(10)]
    public function benchLongStringQuote(): void
    {
        (string) E\string("{$this->long} string ' quote");
    }

    #[Revs(20), Iterations(10)]
    public function benchLongStringEscape(): void
    {
        (string) E\string("{$this->long} string \n escape");
    }
}
