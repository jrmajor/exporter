<?php

namespace Major\Exporter\Tests\Writers;

use Major\Exporter as E;
use Major\Exporter\Tests\TestCase;

final class FileWriterTest extends TestCase
{
    public function testNoImports(): void
    {
        $this->assertSame(
            "<?php\n\nreturn ['foo', 123];\n",
            E\to_file(E\vec([E\string('foo'), E\int(123)])),
        );
    }

    public function testOneTypeImports(): void
    {
        $this->assertSame(
            "<?php\n\nuse Foo\\Bar;\n\nreturn new Bar();\n",
            E\to_file($this->mockExporter(
                'new Bar()',
                new E\Imports(['Foo\\Bar']),
            )),
        );
    }

    public function testMultipleTypeImports(): void
    {
        $this->assertSame(
            <<<'PHP'
                <?php

                use Foo\Bar;

                use const Foo\BAZ_A;
                use const Foo\BAZ_B;

                return new Bar(BAZ_A, BAZ_B);

                PHP,
            E\to_file($this->mockExporter(
                'new Bar(BAZ_A, BAZ_B)',
                new E\Imports(['Foo\\Bar'], [], ['Foo\\BAZ_A', 'Foo\\BAZ_B']),
            )),
        );
    }

    public function testDuplicateImports(): void
    {
        $this->assertSame(
            <<<'PHP'
                <?php

                use Foo\Bar;
                use Foo\Baz;
                use Foo\Foo;

                return [new Foo(new Bar()), new Foo(new Baz())];

                PHP,
            E\to_file(E\vec([
                $this->mockExporter(
                    'new Foo(new Bar())',
                    new E\Imports(['Foo\\Foo', 'Foo\\Bar']),
                ),
                $this->mockExporter(
                    'new Foo(new Baz())',
                    new E\Imports(['Foo\\Bar', 'Foo\\Baz']),
                ),
            ])),
        );
    }
}
