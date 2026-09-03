<?php /** @var \Hks\Facets\Form\Facets\Checkboxes $facet */ ?>

<fieldset <?= attr(A::merge([
    'class' => 'checkbox-group',
    'disabled' => $facet->isDisabled(),
], $attr ?? [])) ?>>
    <legend <?= attr([
        'class' => 'checkbox-group__label',
    ]) ?>>
        <?= esc($facet->label()) ?>
    </legend>

    <ol <?= attr([
        'class' => 'checkbox-group__list',
    ]) ?>>
        <?php foreach ($facet->options() as $option): ?>
            <label <?= attr([
                'class' => [
                    'checkbox-group__item',
                    'checkbox',
                ],
            ]) ?>>
                <input <?= attr([
                    'class' => 'checkbox__input',
                    'type' => 'checkbox',
                    'name' => $facet->name(),
                    'value' => $option->value(),
                    'checked' => $option->isChecked(),
                ]) ?>>

                <span <?= attr([
                    'class' => 'checkbox__label',
                ]) ?>>
                    <?= esc($option->label()) ?>
                </span>
            </label>
        <?php endforeach ?>
    </ol>
</fieldset>
