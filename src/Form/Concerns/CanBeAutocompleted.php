<?php

namespace Hks\Facets\Form\Concerns;

trait CanBeAutocompleted
{
    protected ?string $autocomplete = null;

    public function hasAutocomplete(): bool
    {
        return $this->autocomplete !== null;
    }

    public function autocomplete(?string $value = null): static|string|null
    {
        if ($value !== null) {
            $this->autocomplete = $value;

            return $this;
        }

        return $this->autocomplete;
    }
}
