<?php

namespace Hks\Facets\Form\Concerns;

trait CanHavePlaceholder
{
    protected ?string $placeholder = null;

    public function hasPlaceholder(): bool
    {
        return $this->placeholder !== null;
    }

    public function placeholder(?string $value = null): static|string|null
    {
        if ($value !== null) {
            $this->placeholder = $value;

            return $this;
        }

        return $this->placeholder;
    }
}
