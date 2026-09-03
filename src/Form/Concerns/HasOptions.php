<?php

namespace Hks\Facets\Form\Concerns;

use Closure;
use Hks\Facets\Form\Option;
use Hks\Facets\Form\Options;

trait HasOptions
{
    protected Options|Closure|array|null $options;

    public function hasOptions(): bool
    {
        return $this->options()->isNotEmpty();
    }

    public function hasOption(string $value): bool
    {
        return $this->option($value) !== null;
    }

    public function options(): Options
    {
        if ($this->options instanceof Options) {
            return $this->options;
        }

        return $this->options = $this->resolveOptions();
    }

    public function option(string $value): ?Option
    {
        return $this->options()->get($value);
    }

    abstract public function value(mixed $default = null): mixed;

    protected function formatValue(string $value): string
    {
        return $this->option($value)?->label() ?? parent::formatValue($value);
    }

    protected function resolveOptions(): Options
    {
        $options = $this->options instanceof Closure ? ($this->options)() : $this->options;

        if (! ($options instanceof Options)) {
            $options = Options::factory($options ?? []);
        }

        return $options->checked($this->value());
    }
}
