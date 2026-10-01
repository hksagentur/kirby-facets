<?php

namespace Hks\Facets\Http;

use Kirby\Http\Uri;
use Stringable;

class Query implements Stringable
{
    /** @param array<string, mixed> $parameters */
    public function __construct(
        protected readonly array $parameters = [],
    ) {
    }

    public static function current(): static
    {
        return new static(Uri::current()->query()->toArray());
    }

    public function without(string ...$names): static
    {
        return new static(array_diff_key(
            $this->parameters,
            array_flip($names),
        ));
    }

    public function withoutValue(string $name, string $value): static
    {
        $parameter = $this->parameters[$name] ?? null;

        if (! is_array($parameter)) {
            return $this->without($name);
        }

        $values = array_values(array_diff($parameter, [$value]));

        if ($values === []) {
            return $this->without($name);
        }

        return new static([
            ...$this->parameters,
            $name => $values,
        ]);
    }

    public function toString(bool $questionMark = false): string
    {
        $query = http_build_query(
            data: $this->parameters,
            numeric_prefix: '',
            arg_separator: '&',
            encoding_type: PHP_QUERY_RFC3986,
        );

        if ($query === '') {
            return '';
        }

        if ($questionMark === true) {
            $query = '?' . $query;
        }

        return $query;
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->parameters;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
