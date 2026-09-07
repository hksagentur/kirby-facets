<?php /** @var \Hks\Facets\Form\Facets\Select $facet */ ?>

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

    <div <?= attr([
        'class' => [
            'field__input',
            'select',
        ],
    ]) ?>>
        <select <?= attr([
            'class' => 'select__input',
            'name' => $facet->name(),
            'disabled' => $facet->isDisabled(),
            'required' => $facet->isRequired(),
        ]) ?>>
            <option value="">
                <?= esc($facet->defaultOption() ?? t('hksagentur.facets.select.empty')) ?>
            </option>

            <?php foreach ($facet->options() as $option): ?>
                <option <?= attr([
                    'value' => $option->value(),
                    'selected' => $option->isChecked(),
                ]) ?>>
                    <?= esc($option->label()) ?>
                </option>
            <?php endforeach ?>
        </select>

        <?php snippet([
            'facets/icon--select',
            'facets/icon',
        ], [
            'name' => 'chevron-down',
            'class' => 'select__caret',
        ]) ?>
    </div>
</label>
