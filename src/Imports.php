<?php

namespace Major\Exporter;

use Psl\Dict;
use Psl\Vec;

final readonly class Imports
{
    public function __construct(
        /** @var list<string> */
        public array $class = [],
        /** @var list<string> */
        public array $func = [],
        /** @var list<string> */
        public array $const = [],
    ) { }

    public function merge(self $imports): self
    {
        return new self(
            [...$this->class, ...$imports->class],
            [...$this->func, ...$imports->func],
            [...$this->const, ...$imports->const],
        );
    }

    public function optimized(): self
    {
        return new self(
            Vec\sort(Dict\unique($this->class)),
            Vec\sort(Dict\unique($this->func)),
            Vec\sort(Dict\unique($this->const)),
        );
    }

    public function isEmpty(): bool
    {
        return $this->class === []
            && $this->func === []
            && $this->const === [];
    }
}
