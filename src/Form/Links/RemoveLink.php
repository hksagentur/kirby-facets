<?php

namespace Hks\Facets\Form\Links;

use Hks\Facets\Form\Link;

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

    protected function query(array $parameters): array
    {
        if (is_array($parameters[$this->name] ?? null) === false) {
            unset($parameters[$this->name]);

            return $parameters;
        }

        $parameters[$this->name] = array_values(array_diff($parameters[$this->name], [$this->value]));

        if ($parameters[$this->name] === []) {
            unset($parameters[$this->name]);
        }

        return $parameters;
    }
}
