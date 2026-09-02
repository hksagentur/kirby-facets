<?php /** @var \Hks\Facets\Form\Facets $facets */ ?>

<form <?= attr(A::merge([
    'id' => 'facets',
    'class' => 'facets',
    'method' => 'get'
], $attr ?? [])) ?>>
    <?php foreach ($facets->featured() as $facet): ?>
        <?= $facet ?>
    <?php endforeach ?>

    <?php if ($facets->advanced()->isNotEmpty()): ?>
        <button <?= attr([
            'class' => 'button',
            'type' => 'button',
            'command' => 'show-modal',
            'commandfor' => 'facets-dialog',
        ]) ?>>
            <?= t('hksagentur.facets.form.advanced') ?>
        </button>

        <dialog <?= attr([
            'id' => 'facets-dialog',
            'class' => 'dialog',
            'aria-labelledby' => 'facets-dialog-title',
        ]) ?>>
            <div <?= attr([
                'class' => 'dialog__header',
            ]) ?>>
                <h2 <?= attr([
                    'id' => 'facets-dialog-title',
                    'class' => 'dialog__title',
                ]) ?>>
                    <?= t('hksagentur.facets.form.advanced') ?>
                </h2>

                <button <?= attr([
                    'class' => [
                        'dialog__close',
                        'button',
                    ],
                    'type' => 'button',
                    'command' => 'close',
                    'commandfor' => 'facets-dialog',
                ]) ?>>
                    <?= t('hksagentur.facets.form.close') ?>
                </button>
            </div>

            <?php foreach ($facets as $facet): ?>
                <?= $facet ?>
            <?php endforeach ?>
        </dialog>
    <?php endif ?>

    <?php if ($facets->links()->isNotEmpty()): ?>
        <?= $facets->links() ?>
    <?php endif ?>

    <button <?= attr([
        'class' => 'button',
        'type' => 'submit',
    ]) ?>>
        <?= t('hksagentur.facets.form.apply') ?>
    </button>
</form>
