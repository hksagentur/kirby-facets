<?php

use Kirby\Cms\Collection;
use Hks\Facets\Form\Options;

return [
    'pipe' => function (array $stages): Collection {
        $collection = $this;

        foreach ($stages as $stage) {
            $collection = $stage($collection);
        }

        return $collection;
    },

    'toFacetOptions' => function (
        Closure|string|null $value = null,
        ?string $label = null,
        ?string $icon = null,
    ): Options {
        $get = fn (mixed $item, string|Closure $key) => ($key instanceof Closure)
            ? $key($item)
            : $this->getAttribute($item, $key);

        return Options::factory($this->values(fn (mixed $item) => [
            'value' => $get($item, $value ?? 'id'),
            'label' => $get($item, $label ?? 'title'),
            'icon' => $icon !== null ? $get($item, $icon) : null,
        ]));
    },
];
