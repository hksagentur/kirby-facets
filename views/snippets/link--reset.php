<?php /** @var \Hks\Facets\Form\Link $link */ ?>

<a <?= attr(A::merge([
    'class' => 'link',
    'href' => $link->url(),
    'data-variant' => 'reset',
], $attr ?? [])) ?>>
    <?= esc($link->label()) ?>
</a>
