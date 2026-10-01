<?php

namespace Hks\Facets\Form\Links;

use Hks\Facets\Form\Link;
use Hks\Facets\Http\Query;

class ClearLink extends Link
{
    protected readonly string $name;

    public function __construct(string $label, string $name)
    {
        parent::__construct($label);

        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'name' => $this->name,
        ];
    }

    protected function query(Query $query): Query
    {
        return $query->without($this->name);
    }
}
