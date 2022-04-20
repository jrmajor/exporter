<?php

namespace Major\Exporter\Tests;

use Major\Exporter as E;

final class JoinTest extends TestCase
{
    public function testNoGlue(): void
    {
        $exported = E\join(['Foo', new E\Exported('Bar')]);

        $this->assertTrue($exported->imports->isEmpty());
        $this->assertSame('FooBar', $exported->value);
    }

    public function testWithGlue(): void
    {
        $exported = E\join(['Foo', new E\Exported('Bar')], ' ');

        $this->assertTrue($exported->imports->isEmpty());
        $this->assertSame('Foo Bar', $exported->value);
    }

    public function testWithImports(): void
    {
        $exported = E\join([
            'test:',
            new E\Exported('Foo'),
            new E\Exported('Bar', new E\Imports(['Foo'], ['foo'])),
            new E\Exported('Baz', new E\Imports([], ['bar'], ['FOO'])),
        ], ' ');

        $this->assertSame(['Foo'], $exported->imports->class);
        $this->assertSame(['foo', 'bar'], $exported->imports->func);
        $this->assertSame(['FOO'], $exported->imports->const);
        $this->assertSame('test: Foo Bar Baz', $exported->value);
    }
}
