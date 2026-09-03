<?php

namespace Hks\Facets\Http\Filters;

use Kirby\Cms\Collection;

class After extends Attribute
{
    public function apply(Collection $collection): Collection
    {
        return $collection->filterBy($this->attribute(), 'date >', $this->value());
    }
}
