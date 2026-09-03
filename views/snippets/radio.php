<?php /** @var \Hks\Facets\Form\Facets\Radio $facet */ ?>

<fieldset <?= attr(A::merge([
    'class' => 'radio-group',
    'role' => 'radiogroup',
], $attr ?? [])) ?>>
    <legend <?= attr([
        'class' => 'radio-group__label',
    ]) ?>>
        <?= esc($facet->label()) ?>
    </legend>

    <ol <?= attr([
        'class' => 'radio-group__list',
    ]) ?>>
        <?php foreach ($facet->options() as $option): ?>
            <label <?= attr([
                'class' => [
                    'radio-group__item',
                    'radio',
                ],
            ]) ?>>
                <input <?= attr([
                    'class' => 'radio__input',
                    'type' => 'radio',
                    'name' => $facet->name(),
                    'value' => $option->value(),
                    'checked' => $option->isChecked(),
                ]) ?>>

                <span <?= attr([
                    'class' => 'radio__label',
                ]) ?>>
                    <?= esc($option->label()) ?>
                </span>
            </label>
        <?php endforeach ?>
    </ol>
</fieldset>
