<?php

namespace Hks\Facets\Toolkit;

class Str extends \Kirby\Toolkit\Str
{
    public static function classBasename(string $class): string
    {
        $position = strrpos($class, '\\');

        if ($position === false) {
            return $class;
        }

        return substr($class, $position + 1);
    }
}
