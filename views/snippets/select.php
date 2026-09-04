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

        <svg <?= attr([
            'viewBox' => '0 0 24 24',
            'class' => 'select__caret',
            'aria-hidden' => 'true',
        ]) ?>>
            <path d="M23.468,2.984a2,2,0,0,0-1.742-1.018H2.274A2,2,0,0,0,.563,5L10.289,21.07a2,2,0,0,0,3.422,0L23.437,5A2,2,0,0,0,23.468,2.984Z"/>
        </svg>
    </div>
</label>
