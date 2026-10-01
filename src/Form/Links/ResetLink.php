<?php

namespace Hks\Facets\Form\Links;

use Hks\Facets\Form\Link;
use Hks\Facets\Http\Query;

class ResetLink extends Link
{
    protected readonly array $names;

    /** @param list<string> $names */
    public function __construct(string $label, array $names)
    {
        parent::__construct($label);

        $this->names = $names;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'names' => $this->names,
        ];
    }

    protected function query(Query $query): Query
    {
        return $query->without(...$this->names);
    }
}
