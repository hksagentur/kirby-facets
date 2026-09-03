<?php

namespace Hks\Facets\Form\Facets;

use Hks\Facets\Form\Concerns\CanBeDisabled;
use Hks\Facets\Form\Concerns\CanBeRequired;
use Hks\Facets\Form\Facet;

class Toggle extends Facet
{
    use CanBeDisabled;
    use CanBeRequired;

    public function isChecked(): bool
    {
        return filter_var($this->value(), FILTER_VALIDATE_BOOLEAN);
    }

    protected function formatValue(string $value): string
    {
        return $this->label();
    }
}
