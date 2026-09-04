<?php

namespace Hks\Facets\Form\Concerns;

trait CanHideOptionLabels
{
    protected bool $labels = true;

    public function shouldHideLabels(): bool
    {
        return ! $this->labels;
    }

    public function labels(bool $labels = false): static
    {
        $this->labels = $labels;

        return $this;
    }

    public function hideLabels(): static
    {
        return $this->labels(false);
    }
}
