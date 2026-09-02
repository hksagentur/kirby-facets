<?php

Kirby::plugin('hksagentur/facets', [
    'collectionMethods' => require __DIR__ . '/config/methods/collection.php',
    'snippets' => require __DIR__ . '/config/snippets.php',
    'translations' => require __DIR__ . '/config/translations.php',
]);
