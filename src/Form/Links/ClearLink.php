<?php

namespace Hks\Facets\Form\Links;

use Hks\Facets\Form\Link;

class ClearLink extends Link
{
    protected readonly string $name;

    public function __construct(string $label, string $name)
    {
        parent::__construct($label);

        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'name' => $this->name,
        ];
    }

    protected function query(array $parameters): array
    {
        unset($parameters[$this->name]);

        return $parameters;
    }
}
