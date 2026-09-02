<?php

namespace Hks\Facets\Http\Filter;

use Hks\Facets\Http\Filter;
use Kirby\Cms\Collection;

class Not extends Filter
{
    public function __construct(
        protected readonly Filter $filter
    ) {
        parent::__construct($filter->name());
    }

    public function isEmpty(): bool
    {
        return $this->filter->isEmpty();
    }

    public function name(): string
    {
        return $this->filter->name();
    }

    public function from(string $name): static
    {
        $this->filter->from($name);

        return parent::from($name);
    }

    public function apply(Collection $collection): Collection
    {
        return $collection->not(
            ...$this->filter->apply($collection)->keys()
        );
    }
}
