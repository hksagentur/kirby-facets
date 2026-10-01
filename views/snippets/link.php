<?php /** @var \Hks\Facets\Form\Link $link */ ?>

<a <?= attr(A::merge([
    'class' => 'link',
    'href' => $link->url(),
    'aria-label' => tt('hksagentur.facets.filter.remove', [
        'label' => $link->label(),
    ]),
    'data-variant' => 'remove',
], $attr ?? [])) ?>>
    <?= esc($link->label()) ?>

    <?php snippet('facets/icon', [
        'name' => 'cross',
        'class' => 'link__icon',
    ]) ?>
</a>
