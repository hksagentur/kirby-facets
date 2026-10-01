<?php

namespace Hks\Facets\Form;

use Kirby\Toolkit\Collection;
use Stringable;

/**
 * @template T of Facet
 * @extends Collection<T>
 */
class Facets extends Collection implements Stringable
{
    use Concerns\CanBeRendered;

    public function featured(): static
    {
        return $this->filter(fn (Facet $facet) => $facet->isFeatured());
    }

    public function advanced(): static
    {
        return $this->filter(fn (Facet $facet) => $facet->isAdvanced());
    }

    public function active(): static
    {
        return $this->filter(fn (Facet $facet) => $facet->isActive());
    }

    public function add(Facet $facet): static
    {
        return parent::set($facet->name(), $facet);
    }

    public function set(string|array $key, $value = null): static
    {
        if (is_array($key) === true) {
            foreach ($key as $facet) {
                $this->add($facet);
            }

            return $this;
        }

        return parent::set($key, $value);
    }

    public function links(): Links
    {
        $links = [];

        foreach ($this->active() as $facet) {
            array_push($links, ...$facet->links());
        }

        return new Links($links);
    }

    public function snippet(): string|array
    {
        return 'facets/form';
    }

    public function snippetData(): array
    {
        return [
            'facets' => $this,
        ];
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
