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
        'role' => 'list',
    ]) ?>>
        <?php foreach ($facet->options() as $option): ?>
            <li <?= attr([
                'class' => 'checkbox-group__item',
            ]) ?>>
                <label <?= attr([
                    'class' => 'checkbox',
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
            </li>
        <?php endforeach ?>
    </ol>
</fieldset>
