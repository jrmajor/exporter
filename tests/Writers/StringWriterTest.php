<?php

namespace Major\Exporter\Tests\Writers;

use Major\Exporter as E;
use Major\Exporter\Exceptions\ExportedHasImports;
use Major\Exporter\Tests\TestCase;

final class StringWriterTest extends TestCase
{
    public function testItWorks(): void
    {
        $this->assertSame(
            "['foo', 123]",
            E\to_string(E\vec([E\string('foo'), E\int(123)])),
        );
    }

    public function testItThrows(): void
    {
        $this->expectException(ExportedHasImports::class);
        $this->expectExceptionMessage('Exported value has imports, can not write it to string.');

        E\to_string($this->mockExporter(
            'new Bar()',
            new E\Imports(['Foo\\Bar']),
        ));
    }
}
