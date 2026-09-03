<?php

namespace Hks\Facets\Form\Concerns;

trait CanHaveDefaultOption
{
    protected ?string $defaultOption = null;

    public function hasDefaultOption(): bool
    {
        return $this->defaultOption !== null;
    }

    public function defaultOption(?string $label = null): static|string|null
    {
        if ($label !== null) {
            $this->defaultOption = $label;

            return $this;
        }

        return $this->defaultOption;
    }
}
