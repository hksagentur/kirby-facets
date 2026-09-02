<?php

namespace Hks\Facets\Http\Filter;

use Closure;
use Hks\Facets\Http\Filter;
use Kirby\Cms\Collection;

class Callback extends Filter
{
    public function __construct(
        string $name,
        protected readonly Closure $callback,
    ) {
        parent::__construct($name);
    }

    public function __invoke(Collection $collection): Collection
    {
        return ($this->callback)($collection, $this->value());
    }
}
