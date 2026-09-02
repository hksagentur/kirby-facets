<?php

namespace Hks\Facets\Form;

class Option
{
    public function __construct(
        protected readonly string $label,
        protected readonly string $value,
        protected readonly bool $checked = false,
    ) {
    }

    public static function from(array $props): static
    {
        return new static(
            $props['label'],
            $props['value'],
            $props['checked'] ?? false,
        );
    }

    public function isChecked(): bool
    {
        return $this->checked;
    }

    public function checked(bool $checked = true): static
    {
        return new static($this->label, $this->value, $checked);
    }

    public function label(): string
    {
        return $this->label;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'checked' => $this->checked,
        ];
    }
}
