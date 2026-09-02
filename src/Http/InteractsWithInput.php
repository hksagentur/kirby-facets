<?php

namespace Hks\Facets\Http;

use Kirby\Cms\App;

trait InteractsWithInput
{
    protected string $name;

    public function isEmpty(): bool
    {
        $value = $this->value();

        if ($value !== null && $value !== '') {
            return false;
        }

        return true;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function value(mixed $default = null): mixed
    {
        $value = App::instance()->request()->get($this->name(), $default);

        if (is_string($value)) {
            $value = trim($value);
        }

        return $value;
    }
}
