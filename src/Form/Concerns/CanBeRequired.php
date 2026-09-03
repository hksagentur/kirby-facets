<?php

namespace Hks\Facets\Form\Concerns;

trait CanBeRequired
{
    protected bool $required = false;

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function required(bool $required = true): static
    {
        $this->required = $required;

        return $this;
    }
}
