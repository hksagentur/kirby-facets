<?php

namespace Hks\Facets\Form\Concerns;

trait CanBeReadonly
{
    protected bool $readonly = false;

    public function isReadonly(): bool
    {
        return $this->readonly;
    }

    public function readonly(bool $readonly = true): static
    {
        $this->readonly = $readonly;

        return $this;
    }
}
