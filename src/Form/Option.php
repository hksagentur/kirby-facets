<?php

namespace Hks\Facets\Form;

class Option
{
    public function __construct(
        protected readonly string $label,
        protected readonly string $value,
        protected readonly ?string $icon = null,
        protected readonly bool $checked = false,
    ) {
    }

    public static function from(array $props): static
    {
        return new static(
            $props['label'],
            $props['value'],
            $props['icon'] ?? null,
            $props['checked'] ?? false,
        );
    }

    public function hasIcon(): bool
    {
        return $this->icon !== null;
    }

    public function isChecked(): bool
    {
        return $this->checked;
    }

    public function checked(bool $checked = true): static
    {
        return $this->cloneWith([
            'checked' => $checked,
        ]);
    }

    public function label(): string
    {
        return $this->label;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function icon(): ?string
    {
        return $this->icon;
    }

    public function clone(): static
    {
        return new static($this->label, $this->value, $this->icon, $this->checked);
    }

    public function cloneWith(array $props): static
    {
        return new static(
            $props['label'] ?? $this->label,
            $props['value'] ?? $this->value,
            $props['icon'] ?? $this->icon,
            $props['checked'] ?? $this->checked,
        );
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'icon' => $this->icon,
            'checked' => $this->checked,
        ];
    }
}
