<?php

namespace Hks\Facets\Form\Links;

use Hks\Facets\Form\Link;
use Hks\Facets\Http\Query;

class RemoveLink extends Link
{
    protected readonly string $name;
    protected readonly string $value;

    public function __construct(string $label, string $name, string $value)
    {
        parent::__construct($label);

        $this->name = $name;
        $this->value = $value;
    }

    public static function from(array $props): static
    {
        return new static(
            $props['label'],
            $props['name'],
            $props['value'],
        );
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'name' => $this->name,
            'value' => $this->value,
        ];
    }

    protected function query(Query $query): Query
    {
        return $query->withoutValue($this->name, $this->value);
    }
}
