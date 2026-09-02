<?php

namespace Hks\Facets\Form;

use Kirby\Http\Uri;
use Kirby\Toolkit\Html;
use Stringable;

class Link implements Stringable
{
    public function __construct(
        protected readonly string $name,
        protected readonly string $label,
        protected readonly string $value,
    ) {
    }

    public static function from(array $props): static
    {
        return new static(
            $props['name'],
            $props['label'],
            $props['value'],
        );
    }

    public function label(): string
    {
        return $this->label;
    }

    public function url(): Uri
    {
        $uri = Uri::current();

        return $uri->clone([
            'query' => $this->withoutValue($uri->query->toArray()),
        ]);
    }

    protected function withoutValue(array $query): array
    {
        if (is_array($query[$this->name] ?? null) === false) {
            unset($query[$this->name]);

            return $query;
        }

        $query[$this->name] = array_values(array_diff($query[$this->name], [$this->value]));

        if ($query[$this->name] === []) {
            unset($query[$this->name]);
        }

        return $query;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->label,
            'value' => $this->value,
        ];
    }

    public function toString(): string
    {
        return $this->url();
    }

    public function toHtml(array $attributes = []): string
    {
        return Html::link($this->url(), $this->label(), $attributes);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
