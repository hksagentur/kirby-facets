<?php

namespace Hks\Facets\Form;

use Closure;
use Hks\Facets\Form\Facets\Checkboxes;
use Hks\Facets\Form\Facets\Date;
use Hks\Facets\Form\Facets\Radio;
use Hks\Facets\Form\Facets\Select;
use Hks\Facets\Form\Facets\Toggle;
use Hks\Facets\Form\Links\ClearLink;
use Hks\Facets\Form\Links\RemoveLink;
use Hks\Facets\Http\InteractsWithInput;
use Hks\Facets\Toolkit\Str;
use Kirby\Toolkit\A;
use Kirby\Toolkit\I18n;
use Stringable;

/**
 * @phpstan-import-type ResolvableOptions from Options
 */
abstract class Facet implements Stringable
{
    use Concerns\CanBeFeatured;
    use Concerns\CanBeRendered;
    use InteractsWithInput;

    /** @var (Closure(string $value, string $label): string)|null */
    protected ?Closure $format = null;

    /** @var string|list<string>|null */
    protected string|array|null $default = null;

    public function __construct(
        protected string $label,
        protected string $name,
    ) {
    }

    /** @param ResolvableOptions $options */
    public static function checkboxes(string $label, string $name, Options|Closure|array $options): Checkboxes
    {
        return new Checkboxes($label, $name, $options);
    }

    public static function date(string $label, string $name): Date
    {
        return new Date($label, $name);
    }

    /** @param ResolvableOptions $options */
    public static function radio(string $label, string $name, Options|Closure|array $options): Radio
    {
        return new Radio($label, $name, $options);
    }

    /** @param ResolvableOptions $options */
    public static function select(string $label, string $name, Options|Closure|array $options): Select
    {
        return new Select($label, $name, $options);
    }

    public static function toggle(string $label, string $name): Toggle
    {
        return new Toggle($label, $name);
    }

    public function isActive(): bool
    {
        $value = $this->input();

        return $value !== null && $value !== '';
    }

    public function isEmpty(): bool
    {
        return ! $this->isActive();
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

    public function value(mixed $default = null): mixed
    {
        return $this->input($default ?? $this->default);
    }

    /** @param string|list<string>|null $value */
    public function default(string|array|null $value): static
    {
        $this->default = $value;

        return $this;
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

    /** @return array<int, RemoveLink> */
    public function links(): array
    {
        return array_map(
            fn (string $value) => new RemoveLink(
                label: $this->format($value),
                name: $this->name(),
                value: $value,
            ),
            A::wrap($this->input())
        );
    }

    public function clearLink(?string $label = null): ?ClearLink
    {
        if (! $this->isActive()) {
            return null;
        }

        return new ClearLink(
            label: $label ?? I18n::template('hksagentur.facets.links.clear', replace: ['label' => $this->label()]),
            name: $this->name(),
        );
    }

    /** @param Closure(string $value, string $label): string $formatter */
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
