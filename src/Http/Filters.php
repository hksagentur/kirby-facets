<?php

namespace Hks\Facets\Http;

use Closure;
use Kirby\Toolkit\Collection;

class Filters extends Collection
{
    public function __construct(
        iterable $filters = [],
        protected mixed $subject = null,
    ) {
        foreach ($filters as $filter) {
            $this->add($filter);
        }
    }

    public static function for(mixed $subject): static
    {
        return new static(subject: $subject);
    }

    public function use(array $filters, ?array $only = null): static
    {
        foreach ($filters as $filter) {
            if ($only === null || in_array($filter->name(), $only, true)) {
                $this->add($filter);
            }
        }

        return $this;
    }

    public function add(Filter $filter): static
    {
        $this->set($filter->name(), $filter);

        return $this;
    }

    public function apply(): mixed
    {
        $subject = $this->subject;

        foreach ($this as $filter) {
            $subject = $filter($subject);
        }

        return $subject;
    }

    public function toArray(?Closure $map = null): array
    {
        return parent::toArray($map ?? fn (Filter $filter) => $filter->toArray());
    }
}
