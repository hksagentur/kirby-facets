<?php

namespace Hks\Facets\Form\Concerns;

trait CanBeFeatured
{
    protected bool $featured = false;

    public function isFeatured(): bool
    {
        return $this->featured;
    }

    public function featured(bool $featured = true): static
    {
        $this->featured = $featured;

        return $this;
    }
}
