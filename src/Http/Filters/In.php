<?php

namespace Hks\Facets\Http\Filters;

use Kirby\Toolkit\A;
use Kirby\Cms\Collection;

class In extends Attribute
{
    public function isEmpty(): bool
    {
        return $this->value() === [];
    }

    public function value(mixed $default = null): array
    {
        return A::wrap(parent::value($default));
    }

    public function apply(Collection $collection): Collection
    {
        return $collection->filterBy($this->attribute(), 'in', $this->value());
    }
}
