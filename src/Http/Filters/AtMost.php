<?php

namespace Hks\Facets\Http\Filters;

use Kirby\Cms\Collection;

class AtMost extends Attribute
{
    public function apply(Collection $collection): Collection
    {
        return $collection->filterBy($this->attribute(), 'between', [-INF, (float) $this->value()]);
    }
}
