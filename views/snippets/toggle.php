<?php /** @var \Hks\Facets\Form\Facets\Toggle $facet */ ?>

<label <?= attr(A::merge([
    'class' => 'toggle',
], $attr ?? [])) ?>>
    <input <?= attr([
        'class' => 'toggle__input',
        'type' => 'checkbox',
        'name' => $facet->name(),
        'checked' => $facet->isChecked(),
        'value' => '1',
    ]) ?>>

    <span <?= attr([
        'class' => 'toggle__label',
    ]) ?>>
        <?= esc($facet->label()) ?>
    </span>
</label>
