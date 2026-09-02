<?php

namespace Hks\Facets\Http\Filter;

use Hks\Facets\Http\Filter;

abstract class Attribute extends Filter
{
    protected readonly string $attribute;

    public function __construct(string $name, ?string $attribute = null)
    {
        parent::__construct($name);

        $this->attribute = $attribute ?? $name;
    }

    public function attribute(): string
    {
        return $this->attribute;
    }
}
