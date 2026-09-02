<?php

namespace Hks\Facets\Form;

use Closure;
use Kirby\Toolkit\Collection;
use Stringable;

/**
 * @template T of Link
 * @extends Collection<T>
 */
class Links extends Collection implements Stringable
{
    public function render(array $data = []): string
    {
        return snippet('facets/links', [
            'links' => $this,
            ...$data,
        ], return: true);
    }

    public function toArray(?Closure $map = null): array
    {
        return parent::toArray($map ?? fn (Link $option) => $option->toArray());
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
