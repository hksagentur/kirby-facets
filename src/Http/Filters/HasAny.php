<?php

namespace Hks\Facets\Http\Filters;

use Kirby\Cms\Collection;
use Kirby\Toolkit\A;
use Kirby\Toolkit\Str;

class HasAny extends Attribute
{
    public function isEmpty(): bool
    {
        return $this->value() === [];
    }

    public function value(mixed $default = null): array
    {
        return A::wrap(parent::value($default));
    }

    public function apply(Collection $collection): Collection
    {
        return $collection->filter(fn ($item) => $this->intersects(
            $collection->getAttribute($item, $this->attribute()),
            $this->value(),
        ));
    }

    protected function intersects(mixed $value, array $keys): bool
    {
        if ($value instanceof Collection) {
            foreach ($keys as $key) {
                if ($value->has($key)) {
                    return true;
                }
            }

            return false;
        }

        $values = Str::split((string) $value, ',');
        $matches = array_intersect($values, $keys);

        return $matches !== [];
    }
}
