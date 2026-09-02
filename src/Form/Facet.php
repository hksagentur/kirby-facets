<?php

namespace Hks\Facets\Form;

use Closure;
use Hks\Facets\Form\Facet\Checkboxes;
use Hks\Facets\Form\Facet\Date;
use Hks\Facets\Form\Facet\Radio;
use Hks\Facets\Form\Facet\Toggle;
use Hks\Facets\Http\InteractsWithInput;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;
use Stringable;

abstract class Facet implements Stringable
{
    use InteractsWithInput;

    protected ?Closure $format = null;

    public function __construct(
        protected string $name,
        protected string $label,
        protected bool $featured = false,
    ) {
    }

    public static function checkboxes(string $name, string $label, array|Closure $options, bool $featured = false): Checkboxes
    {
        return new Checkboxes($name, $label, $options, $featured);
    }

    public static function date(string $name, string $label, bool $featured = false): Date
    {
        return new Date($name, $label, $featured);
    }

    public static function radio(string $name, string $label, array|Closure $options, bool $featured = false): Radio
    {
        return new Radio($name, $label, $options, $featured);
    }

    public static function toggle(string $name, string $label, bool $featured = false): Toggle
    {
        return new Toggle($name, $label, $featured);
    }

    public function isFeatured(): bool
    {
        return $this->featured;
    }

    public function isAdvanced(): bool
    {
        return ! $this->isFeatured();
    }

    public function isActive(): bool
    {
        return ! $this->isEmpty();
    }

    public function label(): string
    {
        return $this->label;
    }

    public function type(): string
    {
        return strtolower(substr(static::class, strrpos(static::class, '\\') + 1));
    }

    public function snippet(): string
    {
        return Str::slug($this->type());
    }

    public function safeName(): string
    {
        return Str::slug($this->name());
    }

    /** @return array<int, Link> */
    public function links(): array
    {
        return array_map(
            fn (string $value) => new Link($this->name(), $this->format($value), $value),
            A::wrap($this->value())
        );
    }

    public function formatUsing(Closure $formatter): static
    {
        $this->format = $formatter;

        return $this;
    }

    public function format(string $value): string
    {
        $label = $this->formatValue($value);

        if ($this->format !== null) {
            $label = ($this->format)($value, $label);
        }

        return $label;
    }

    protected function formatValue(string $value): string
    {
        return Str::label($value);
    }

    public function render(array $data = []): string
    {
        return snippet([
            "facets/{$this->snippet()}--{$this->safeName()}",
            "facets/{$this->snippet()}",
        ], [
            'facet' => $this,
            ...$data,
        ], return: true);
    }

    public function toString(): string
    {
        return $this->render();
    }

    public function toHtml(array $attributes = []): string
    {
        return $this->render([
            'attr' => $attributes,
        ]);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
