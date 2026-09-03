<?php /** @var \Hks\Facets\Form\Facets $facets */ ?>

<form <?= attr(A::merge([
    'id' => 'filters',
    'class' => 'facets',
    'method' => 'get'
], $attr ?? [])) ?>>
    <?php foreach ($facets->featured() as $facet): ?>
        <?= $facet ?>
    <?php endforeach ?>

    <button <?= attr([
        'class' => 'button',
        'type' => 'submit',
    ]) ?>>
        <?= t('hksagentur.facets.form.apply') ?>
    </button>

    <?php if ($facets->advanced()->isNotEmpty()): ?>
        <button <?= attr([
            'class' => 'button',
            'type' => 'button',
            'command' => 'show-modal',
            'commandfor' => 'filter-dialog',
        ]) ?>>
            <?= t('hksagentur.facets.form.more') ?>
        </button>

        <dialog <?= attr([
            'id' => 'filter-dialog',
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
                    <?= t('hksagentur.facets.dialog.title') ?>
                </h2>

                <button <?= attr([
                    'class' => [
                        'dialog__close',
                        'button',
                    ],
                    'type' => 'button',
                    'command' => 'close',
                    'commandfor' => 'filter-dialog',
                ]) ?>>
                    <?= t('hksagentur.facets.dialog.close') ?>
                </button>
            </div>

            <?php foreach ($facets->advanced() as $facet): ?>
                <?= $facet ?>
            <?php endforeach ?>
        </dialog>
    <?php endif ?>
</form>

<?php if ($facets->links()->isNotEmpty()): ?>
    <section <?= attr([
        'id' => 'active-filters',
        'aria-labelledby' => 'active-filters-title',
    ]) ?>>
        <h2 <?= attr([
            'id' => 'active-filters-title',
            'class' => 'visually-hidden',
        ]) ?>>
            <?= t('hksagentur.facets.links.title') ?>
        </h2>

        <?= $facets->links() ?>
    </section>
<?php endif ?>
