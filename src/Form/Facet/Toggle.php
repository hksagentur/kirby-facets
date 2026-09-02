<?php

namespace Hks\Facets\Form\Facet;

use Hks\Facets\Form\Facet;

class Toggle extends Facet
{
    public function isChecked(): bool
    {
        return filter_var($this->value(), FILTER_VALIDATE_BOOLEAN);
    }

    protected function formatValue(string $value): string
    {
        return $this->label();
    }
}
