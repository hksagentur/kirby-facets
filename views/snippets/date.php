<?php /** @var \Hks\Facets\Form\Facets\Date $facet */ ?>

<label <?= attr(A::merge([
    'class' => 'field',
], $attr ?? [])) ?>>
    <span <?= attr([
        'class' => [
            'field__label',
            'label',
        ],
    ]) ?>>
        <?= esc($facet->label()) ?>
    </span>

    <input <?= attr([
        'class' => [
            'field__input',
            'input',
        ],
        'type' => 'date',
        'name' => $facet->name(),
        'value' => $facet->value(),
    ]) ?>>
</label>
