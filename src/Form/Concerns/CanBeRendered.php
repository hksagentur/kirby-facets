<?php

namespace Hks\Facets\Form\Concerns;

use Kirby\Cms\App;

trait CanBeRendered
{
    /** @return string|list<string> */
    abstract public function snippet(): string|array;

    /** @return array<string, mixed> */
    public function snippetData(): array
    {
        return [];
    }

    /** @param array<string, mixed> $data */
    public function render(array $data = []): string
    {
        return App::instance()->snippet($this->snippet(), [
            ...$data,
            ...$this->snippetData(),
        ], return: true);
    }

    public function toHtml(array $attributes = []): string
    {
        return $this->render([
            'attr' => $attributes,
        ]);
    }
}
