<?php /** @var \Hks\Facets\Form\Link $link */ ?>

<a <?= attr(A::merge([
    'class' => 'link',
    'href' => $link->url(),
    'data-variant' => 'clear',
], $attr ?? [])) ?>>
    <?= esc($link->label()) ?>
</a>
