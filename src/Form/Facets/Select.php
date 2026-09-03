<?php

namespace Hks\Facets\Form\Facets;

use Closure;
use Hks\Facets\Form\Concerns\CanBeDisabled;
use Hks\Facets\Form\Concerns\CanBeRequired;
use Hks\Facets\Form\Concerns\CanHaveDefaultOption;
use Hks\Facets\Form\Concerns\HasOptions;
use Hks\Facets\Form\Facet;
use Hks\Facets\Form\Options;

class Select extends Facet
{
    use CanBeDisabled;
    use CanBeRequired;
    use CanHaveDefaultOption;
    use HasOptions;

    public function __construct(
        protected string $name,
        protected string $label,
        protected Options|Closure|array|null $options = null,
        protected bool $featured = false,
    ) {
    }
}
