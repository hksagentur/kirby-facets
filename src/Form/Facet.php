<?php

namespace Hks\Facets\Form;

use Closure;
use Hks\Facets\Form\Facets\Checkboxes;
use Hks\Facets\Form\Facets\Date;
use Hks\Facets\Form\Facets\Radio;
use Hks\Facets\Form\Facets\Select;
use Hks\Facets\Form\Facets\Toggle;
use Hks\Facets\Http\InteractsWithInput;
use Hks\Facets\Toolkit\Str;
use Kirby\Toolkit\A;
use Stringable;

abstract class Facet implements Stringable
{
    use Concerns\CanBeFeatured;
    use Concerns\CanBeRendered;
    use InteractsWithInput;

    protected ?Closure $format = null;

    public function __construct(
        protected string $label,
        protected string $name,
    ) {
    }

    public static function checkboxes(string $label, string $name, array|Closure $options): Checkboxes
    {
        return new Checkboxes($label, $name, $options);
    }

    public static function date(string $label, string $name): Date
    {
        return new Date($label, $name);
    }

    public static function radio(string $label, string $name, array|Closure $options): Radio
    {
        return new Radio($label, $name, $options);
    }

    public static function select(string $label, string $name, array|Closure $options): Select
    {
        return new Select($label, $name, $options);
    }

    public static function toggle(string $label, string $name): Toggle
    {
        return new Toggle($label, $name);
    }

    public function isActive(): bool
    {
        return $this->isNotEmpty();
    }

    public function isAdvanced(): bool
    {
        return ! $this->isFeatured();
    }

    public function type(): string
    {
        return Str::snake(Str::classBasename(static::class));
    }

    public function label(): string
    {
        return $this->label;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function snippet(): string|array
    {
        $type = Str::slug($this->type());
        $name = Str::slug($this->name());

        return [
            "facets/{$type}--{$name}",
            "facets/{$type}",
        ];
    }

    public function snippetData(): array
    {
        return [
            'facet' => $this,
        ];
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

    public function toString(): string
    {
        return $this->render();
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
