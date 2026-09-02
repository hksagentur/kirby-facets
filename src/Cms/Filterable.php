<?php

namespace Hks\Facets\Cms;

use Hks\Facets\Http\Filter;

interface Filterable
{
    /** @return Filter[] */
    public static function filters(): array;
}
