<?php

namespace Hks\Facets\Form\Concerns;

trait CanBeDisabled
{
    protected bool $disabled = false;

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function disabled(bool $disabled = true): static
    {
        $this->disabled = $disabled;

        return $this;
    }
}
