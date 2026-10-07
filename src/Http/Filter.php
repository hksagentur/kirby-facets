<?php

namespace Hks\Facets\Http;

use Closure;
use Hks\Facets\Http\Filters\After;
use Hks\Facets\Http\Filters\AtLeast;
use Hks\Facets\Http\Filters\AtMost;
use Hks\Facets\Http\Filters\BelongsTo;
use Hks\Facets\Http\Filters\Before;
use Hks\Facets\Http\Filters\Callback;
use Hks\Facets\Http\Filters\Equals;
use Hks\Facets\Http\Filters\HasAny;
use Hks\Facets\Http\Filters\In;
use Hks\Facets\Http\Filters\Not;
use Hks\Facets\Http\Filters\Search;
use Kirby\Cms\Collection;

abstract class Filter
{
    use InteractsWithInput;

    public function __construct(
        protected string $name
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function from(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public static function after(string $name, ?string $attribute = null): After
    {
        return new After($name, $attribute);
    }

    public static function atLeast(string $name, ?string $attribute = null): AtLeast
    {
        return new AtLeast($name, $attribute);
    }

    public static function atMost(string $name, ?string $attribute = null): AtMost
    {
        return new AtMost($name, $attribute);
    }

    public static function belongsTo(string $name, string $collection, ?string $attribute = null): BelongsTo
    {
        return new BelongsTo($name, $collection, $attribute);
    }

    public static function before(string $name, ?string $attribute = null): Before
    {
        return new Before($name, $attribute);
    }

    public static function callback(string $name, Closure $callback): Callback
    {
        return new Callback($name, $callback);
    }

    public static function equals(string $name, ?string $attribute = null): Equals
    {
        return new Equals($name, $attribute);
    }

    public static function hasAny(string $name, ?string $attribute = null): HasAny
    {
        return new HasAny($name, $attribute);
    }

    public static function in(string $name, ?string $attribute = null): In
    {
        return new In($name, $attribute);
    }

    public static function not(Filter $filter): Not
    {
        return new Not($filter);
    }

    public static function search(array $fields, string $name = 'q'): Search
    {
        return new Search($fields, $name);
    }

    public function apply(Collection $collection): Collection
    {
        return $collection;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'value' => $this->value(),
        ];
    }

    public function __invoke(Collection $collection): Collection
    {
        return $this->isEmpty() ? $collection : $this->apply($collection);
    }
}
