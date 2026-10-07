<?php

namespace Hks\Facets\Form;

use Hks\Facets\Toolkit\Str;
use Stringable;

class Format implements Stringable
{
    public function __construct(
        protected readonly ?string $prefix = null,
        protected readonly ?string $suffix = null,
        protected readonly ?string $template = null,
    ) {
    }

    public static function prefix(string $prefix): static
    {
        return new static(prefix: $prefix);
    }

    public static function suffix(string $suffix): static
    {
        return new static(suffix: $suffix);
    }

    public static function template(string $template): static
    {
        return new static(template: $template);
    }

    public function __invoke(string $value, string $label): string
    {
        return Str::template($this->toString(), [
            'value' => $value,
            'label' => $label,
        ]);
    }

    public function toString(): string
    {
        return implode(' ', array_filter(
            [$this->prefix, $this->template ?? '{{ label }}', $this->suffix],
            fn (?string $part) => $part !== null && $part !== '',
        ));
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
