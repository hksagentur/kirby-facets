<?php

namespace Hks\Facets\Form\Facets;

use Hks\Facets\Form\Concerns\CanBeAutocompleted;
use Hks\Facets\Form\Concerns\CanBeDisabled;
use Hks\Facets\Form\Concerns\CanBeReadonly;
use Hks\Facets\Form\Concerns\CanBeRequired;
use Hks\Facets\Form\Concerns\CanHavePlaceholder;
use Hks\Facets\Form\Facet;
use Kirby\Toolkit\Str;

class Date extends Facet
{
    use CanBeAutocompleted;
    use CanBeDisabled;
    use CanBeReadonly;
    use CanBeRequired;
    use CanHavePlaceholder;

    protected function formatValue(string $value): string
    {
        $time = strtotime($value);

        if (! $time) {
            return Str::label($value);
        }

        return Str::date($time, 'd.m.Y');
    }
}
