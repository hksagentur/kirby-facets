<?php

namespace Hks\Facets\Form\Facets;

use Closure;
use Hks\Facets\Form\Concerns\HasOptions;
use Hks\Facets\Form\Facet;
use Hks\Facets\Form\Options;

class Checkboxes extends Facet
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
