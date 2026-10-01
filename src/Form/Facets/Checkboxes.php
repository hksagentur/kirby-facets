<?php

namespace Hks\Facets\Form\Facets;

use Closure;
use Hks\Facets\Form\Concerns\CanBeDisabled;
use Hks\Facets\Form\Concerns\CanHideOptionLabels;
use Hks\Facets\Form\Concerns\HasOptions;
use Hks\Facets\Form\Facet;
use Hks\Facets\Form\Options;

class Checkboxes extends Facet
{
    use CanBeDisabled;
    use CanHideOptionLabels;
    use HasOptions;

    public function __construct(
        protected string $label,
        protected string $name,
        protected Options|Closure|array $options,
    ) {
    }
}
