<?php

namespace Hks\Facets\Form\Links;

use Hks\Facets\Form\Link;

class ResetLink extends Link
{
    protected readonly array $names;

    /** @param list<string> $names */
    public function __construct(string $label, array $names)
    {
        parent::__construct($label);

        $this->names = $names;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'names' => $this->names,
        ];
    }

    protected function query(array $parameters): array
    {
        return array_diff_key($parameters, array_flip($this->names));
    }
}
