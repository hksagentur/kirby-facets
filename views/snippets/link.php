<?php /** @var \Hks\Facets\Form\Link $item */ ?>

<a <?= attr(A::merge([
    'class' => 'chip',
    'href' => $item->url(),
    'aria-label' => tt('hksagentur.facets.filter.remove', [
        'label' => $item->label(),
    ]),
], $attr ?? [])) ?>>
    <?= esc($item->label()) ?>

    <?php snippet('facets/icon', [
        'name' => 'cross',
        'class' => [
            'chip__icon',
            'chip__icon--trailing',
        ],
    ]) ?>
</a>
