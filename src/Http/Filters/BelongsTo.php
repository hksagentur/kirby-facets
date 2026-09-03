<?php

namespace Hks\Facets\Http\Filters;

use Kirby\Cms\App;
use Kirby\Cms\Collection;
use Kirby\Cms\Pages;
use Kirby\Content\Field;
use Kirby\Toolkit\A;

class BelongsTo extends Attribute
{
    protected ?Pages $pages = null;

    public function __construct(
        string $name,
        protected readonly string $relation,
        ?string $attribute = null,
    ) {
        parent::__construct($name, $attribute);
    }

    public function isEmpty(): bool
    {
        return $this->value() === [];
    }

    public function value(mixed $default = null): array
    {
        return A::wrap(parent::value($default));
    }

    public function pages(): Pages
    {
        return $this->pages ??= App::instance()
            ->collection($this->relation)
            ->find($this->value());
    }

    public function apply(Collection $collection): Collection
    {
        return $collection->filter(function ($item) use ($collection) {
            $value = $collection->getAttribute($item, $this->attribute());

            if ($value instanceof Field) {
                $value = $value->toPages();
            }

            if ($value instanceof Collection) {
                return $value->intersects($this->pages());
            }

            return false;
        });
    }
}
