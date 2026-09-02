<?php

namespace Hks\Facets\Http\Filter;

use Kirby\Cms\Collection;

class Before extends Attribute
{
    public function apply(Collection $collection): Collection
    {
        return $collection->filterBy($this->attribute(), 'date <', $this->value());
    }
}
