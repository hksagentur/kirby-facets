<?php /** @var \Hks\Facets\Form\Link $link */ ?>

<a <?= attr(A::merge([
    'class' => 'chip',
    'href' => $link->url(),
    'aria-label' => tt('hksagentur.facets.filter.remove', [
        'label' => $link->label(),
    ]),
    'data-variant' => 'remove',
], $attr ?? [])) ?>>
    <?= esc($link->label()) ?>

    <?php snippet('facets/icon', [
        'name' => 'cross',
        'class' => 'chip__icon',
    ]) ?>
</a>
