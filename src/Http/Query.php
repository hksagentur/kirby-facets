<?php

namespace Hks\Facets\Http;

class Query
{
    /** @param array<string, mixed> $parameters */
    public function __construct(
        protected readonly array $parameters = [],
    ) {
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

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return $this->parameters;
    }
}
