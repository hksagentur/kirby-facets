<?php

namespace Hks\Facets\Http\Filter;

use Hks\Facets\Http\Filter;
use Kirby\Cms\Collection;

class Search extends Filter
{
    /**
     * @param string[] $fields
     */
    public function __construct(
        protected readonly array $fields,
        string $name = 'q',
    ) {
        parent::__construct($name);
    }

    public function apply(Collection $collection): Collection
    {
        return $collection->search((string) $this->value(), ['fields' => $this->fields]);
    }
}
