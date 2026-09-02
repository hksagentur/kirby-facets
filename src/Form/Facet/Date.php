<?php

namespace Hks\Facets\Form\Facet;

use Hks\Facets\Form\Facet;
use Kirby\Toolkit\Str;

class Date extends Facet
{
    protected function formatValue(string $value): string
    {
        $time = strtotime($value);

        if (! $time) {
            return Str::label($value);
        }

        return Str::date($time, 'd.m.Y');
    }
}
