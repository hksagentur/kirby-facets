<?php

namespace Hks\Facets\Http;

use Kirby\Cms\App;
use Kirby\Cms\Page;
use Kirby\Cms\Pages;
use Kirby\Toolkit\Str;
use Kirby\Uuid\Uuid;

trait InteractsWithInput
{
    public function isEmpty(): bool
    {
        $value = $this->value();

        if ($value !== null && $value !== '') {
            return false;
        }

        return true;
    }

    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }

    abstract public function name(): string;

    public function value(mixed $default = null): mixed
    {
        return $this->input($default);
    }

    public function input(mixed $default = null): mixed
    {
        $value = App::instance()->request()->get($this->name(), $default);

        if (is_string($value)) {
            $value = trim($value);
        }

        return $value;
    }

    /** @return array<int, string> */
    public function split(string $separator = ','): array
    {
        $value = $this->value();

        if (is_array($value)) {
            return array_values(array_filter(
                array_map(fn (mixed $item) => is_string($item) ? trim($item) : '', $value),
                fn (string $item) => $item !== '',
            ));
        }

        if (is_string($value)) {
            return Str::split($value, $separator);
        }

        return [];
    }

    public function toBool(bool $default = false): bool
    {
        return filter_var(
            $this->value(),
            FILTER_VALIDATE_BOOLEAN,
            FILTER_NULL_ON_FAILURE,
        ) ?? $default;
    }

    public function toInt(int $default = 0): int
    {
        $value = $this->value();

        if (! is_numeric($value)) {
            return $default;
        }

        return (int) $value;
    }

    public function toFloat(float $default = 0): float
    {
        $value = $this->value();

        if (! is_numeric($value)) {
            return $default;
        }

        return (float) $value;
    }

    public function toTimestamp(?int $default = null): ?int
    {
        if ($this->isEmpty()) {
            return $default;
        }

        $value = $this->value();

        if (! is_string($value)) {
            return $default;
        }

        $time = strtotime($value);

        if ($time === false) {
            return $default;
        }

        return $time;
    }

    public function toDate(?string $format = null, ?string $default = null): int|string|null
    {
        $time = $this->toTimestamp(strtotime($default ?? '') ?: null);

        if ($time === null) {
            return null;
        }

        return Str::date($time, $format);
    }

    public function toPage(?Pages $scope = null): ?Page
    {
        return $this->toPages($scope)->first();
    }

    public function toPages(?Pages $scope = null): Pages
    {
        $pages = new Pages();

        foreach ($this->split() as $key) {
            if ($page = $this->resolvePage($key, $scope)) {
                $pages->add($page);
            }
        }

        return $pages;
    }

    protected function resolvePage(string $key, ?Pages $scope = null): ?Page
    {
        $key = preg_replace('!^(@|page://)!', '', $key);

        if ($scope) {
            return $scope->get($key) ?? $scope->findByUuid('page://' . $key);
        }

        if ($page = App::instance()->site()->find($key)) {
            return $page;
        }

        $page = Uuid::for('page://' . $key)?->model(lazy: true);

        if ($page instanceof Page && ! $page->isDraft()) {
            return $page;
        }

        return null;
    }
}
