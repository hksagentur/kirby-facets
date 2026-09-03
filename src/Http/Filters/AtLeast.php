<?php

namespace Hks\Facets\Http\Filters;

use Kirby\Cms\Collection;

class AtLeast extends Attribute
{
    public function apply(Collection $collection): Collection
    {
        return $collection->filterBy($this->attribute(), 'between', [(float) $this->value(), INF]);
    }
}
