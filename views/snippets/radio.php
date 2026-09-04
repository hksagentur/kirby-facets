<?php /** @var \Hks\Facets\Form\Facets\Radio $facet */ ?>

<fieldset <?= attr(A::merge([
    'class' => 'radio-group',
    'role' => 'radiogroup',
    'disabled' => $facet->isDisabled(),
], $attr ?? [])) ?>>
    <legend <?= attr([
        'class' => 'radio-group__label',
    ]) ?>>
        <?= esc($facet->label()) ?>
    </legend>

    <ol <?= attr([
        'class' => 'radio-group__list',
        'role' => 'list',
    ]) ?>>
        <?php foreach ($facet->options() as $option): ?>
            <li <?= attr([
                'class' => 'radio-group__item',
            ]) ?>>
                <label <?= attr([
                    'class' => 'radio',
                ]) ?>>
                    <input <?= attr([
                        'class' => 'radio__input',
                        'type' => 'radio',
                        'name' => $facet->name(),
                        'value' => $option->value(),
                        'checked' => $option->isChecked(),
                        'required' => $facet->isRequired(),
                    ]) ?>>

                    <?php if ($option->hasIcon()): ?>
                        <?= snippet([
                            'facets/icon--radio',
                            'facets/icon',
                        ], [
                            'name' => $option->icon(),
                            'class' => 'radio__icon',
                        ]) ?>
                    <?php endif ?>

                    <span <?= attr([
                        'class' => [
                            'radio__label',
                            ...$facet->shouldHideLabels() ? ['visually-hidden'] : [],
                        ],
                    ]) ?>>
                        <?= esc($option->label()) ?>
                    </span>
                </label>
            </li>
        <?php endforeach ?>
    </ol>
</fieldset>
