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
    use Concerns\CanBeRendered;

    public function hasMultiple(): bool
    {
        return $this->count() > 1;
    }

    public function snippet(): string|array
    {
        return 'facets/links';
    }

    public function snippetData(): array
    {
        return [
            'links' => $this,
        ];
    }

    public function toArray(?Closure $map = null): array
    {
        return parent::toArray($map ?? fn (Link $option) => $option->toArray());
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
