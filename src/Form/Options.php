<?php

namespace Hks\Facets\Form;

use Closure;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Collection;

/**
 * @template T of Option
 * @extends Collection<T>
 */
class Options extends Collection
{
    /** @param array<int, array{value: string, label: string}> $options */
    public static function factory(array $options, mixed $checked = null): static
    {
        $checked = A::wrap($checked);

        $items = array_map(
            fn (array $option) => new Option(
                $option['label'],
                $option['value'],
                in_array($option['value'], $checked, true),
            ),
            $options
        );

        return new static($items);
    }

    public function add(Option $option): static
    {
        return $this->set($option->value(), $option);
    }

    public function checked(mixed $value): static
    {
        return $this->clone()->map(fn (Option $option) => $option->checked(
            in_array($option->value(), A::wrap($value), true)
        ));
    }

    public function set(string|array $key, $value = null): static
    {
        if (is_array($key) === true) {
            foreach ($key as $option) {
                $this->add($option);
            }

            return $this;
        }

        return parent::set($key, $value);
    }

    public function toArray(?Closure $map = null): array
    {
        return parent::toArray($map ?? fn (Option $option) => $option->toArray());
    }
}
