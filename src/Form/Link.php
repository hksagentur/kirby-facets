<?php

namespace Hks\Facets\Form;

use Hks\Facets\Http\Query;
use Hks\Facets\Toolkit\Str;
use Kirby\Http\Uri;
use Stringable;

abstract class Link implements Stringable
{
    use Concerns\CanBeRendered;

    public function __construct(
        protected readonly string $label,
    ) {
    }

    abstract protected function query(Query $query): Query;

    public function type(): string
    {
        return Str::snake(Str::before(Str::classBasename(static::class), 'Link'));
    }

    public function label(): string
    {
        return $this->label;
    }

    public function url(): Uri
    {
        $uri = Uri::current();

        return $uri->clone([
            'query' => $this->query(new Query($uri->query->toArray()))->toArray(),
        ]);
    }

    public function snippet(): string|array
    {
        return [
            'facets/link--' . Str::slug($this->type()),
            'facets/link',
        ];
    }

    public function snippetData(): array
    {
        return [
            'link' => $this,
        ];
    }

    public function toString(): string
    {
        return $this->render();
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
        ];
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
