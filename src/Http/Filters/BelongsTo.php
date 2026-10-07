<?php

namespace Hks\Facets\Http\Filters;

use Kirby\Cms\App;
use Kirby\Cms\Collection;
use Kirby\Cms\Page;
use Kirby\Cms\Pages;
use Kirby\Content\Field;
use Kirby\Toolkit\A;

class BelongsTo extends Attribute
{
    protected ?Pages $pages = null;

    /** @var array<int, string>|null */
    protected ?array $references = null;

    public function __construct(
        string $name,
        protected readonly string $collection,
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
        return $this->pages ??= $this->toPages(
            App::instance()->collection($this->collection)
        );
    }

    public function apply(Collection $collection): Collection
    {
        return $collection->filter(function ($item) use ($collection) {
            $value = $collection->getAttribute($item, $this->attribute());

            return match (true) {
                $value instanceof Field => array_intersect($value->yaml(), $this->references()) !== [],
                $value instanceof Page => $this->pages()->has($value),
                $value instanceof Collection => $value->intersects($this->pages()),
                default => false,
            };
        });
    }

    /** @return array<int, string> */
    protected function references(): array
    {
        if ($this->references !== null) {
            return $this->references;
        }

        $this->references = [];

        foreach ($this->pages() as $page) {
            $this->references[] = $page->id();

            if ($uuid = $page->uuid()) {
                $this->references[] = $uuid->toString();
            }
        }

        return $this->references;
    }
}
