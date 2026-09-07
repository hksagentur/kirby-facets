<?php /** @var \Hks\Facets\Form\Link $item */ ?>

<a <?= attr([
    'class' => 'chip',
    'href' => $item->url(),
    'aria-label' => tt('hksagentur.facets.filter.remove', [
        'label' => $item->label(),
    ]),
]) ?>>
    <?= esc($item->label()) ?>

    <?php snippet('facets/icon', [
        'name' => 'cross',
        'class' => [
            'chip__icon',
            'chip__icon--trailing',
        ],
    ]) ?>
</a>
