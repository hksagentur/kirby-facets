<?php

namespace Hks\Facets\Form\Facet;

use Closure;
use Hks\Facets\Form\Facet;
use Hks\Facets\Form\HasOptions;
use Hks\Facets\Form\Options;

class Radio extends Facet
{
    use HasOptions;

    public function __construct(
        protected string $name,
        protected string $label,
        protected Options|Closure|array|null $options = null,
        protected bool $featured = false,
    ) {
    }
}
