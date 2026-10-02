<?php

namespace Hks\Facets\Form\Facets;

use Closure;
use Hks\Facets\Form\Concerns\CanBeDisabled;
use Hks\Facets\Form\Concerns\CanBeRequired;
use Hks\Facets\Form\Concerns\CanHaveDefaultOption;
use Hks\Facets\Form\Concerns\HasOptions;
use Hks\Facets\Form\Facet;
use Hks\Facets\Form\Options;

/**
 * @phpstan-import-type ResolvableOptions from Options
 */
class Select extends Facet
{
    use CanBeDisabled;
    use CanBeRequired;
    use CanHaveDefaultOption;
    use HasOptions;

    /** @param ResolvableOptions $options */
    public function __construct(
        protected string $label,
        protected string $name,
        protected Options|Closure|array $options,
    ) {
    }
}
