<?php

namespace Hks\Facets\Form\Facets;

use Closure;
use Hks\Facets\Form\Concerns\CanBeDisabled;
use Hks\Facets\Form\Concerns\CanBeRequired;
use Hks\Facets\Form\Concerns\CanHideOptionLabels;
use Hks\Facets\Form\Concerns\HasOptions;
use Hks\Facets\Form\Facet;
use Hks\Facets\Form\Options;

class Radio extends Facet
{
    use CanBeDisabled;
    use CanBeRequired;
    use CanHideOptionLabels;
    use HasOptions;

    public function __construct(
        protected string $label,
        protected string $name,
        protected Options|Closure|array $options,
    ) {
    }
}
