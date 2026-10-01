<?php /** @var \Hks\Facets\Form\Facets $facets */ ?>

<form <?= attr(A::merge([
    'id' => 'filters',
    'class' => [
        'filters',
        'form',
    ],
    'method' => 'get',
    'aria-labelledby' => 'filters-title',
], $attr ?? [])) ?>>
    <h2 <?= attr([
        'id' => 'filters-title',
        'class' => [
            'form__title',
            'visually-hidden',
        ],
    ]) ?>>
        <?= t('hksagentur.facets.form.title') ?>
    </h2>

    <?php foreach ($facets->featured() as $facet): ?>
        <?= $facet ?>
    <?php endforeach ?>

    <div <?= attr([
        'class' => 'form__actions',
    ]) ?>>
        <button <?= attr([
            'class' => 'button',
            'type' => 'submit',
        ]) ?>>
            <?= t('hksagentur.facets.form.apply') ?>
        </button>

        <?= $facets->resetLink() ?>

        <?php if ($facets->advanced()->isNotEmpty()): ?>
            <button <?= attr([
                'class' => 'button',
                'type' => 'button',
                'command' => 'show-modal',
                'commandfor' => 'filter-dialog',
            ]) ?>>
                <?= t('hksagentur.facets.form.more') ?>
            </button>
        <?php endif ?>
    </div>

    <?php if ($facets->advanced()->isNotEmpty()): ?>
        <dialog <?= attr([
            'id' => 'filter-dialog',
            'class' => 'drawer',
            'aria-labelledby' => 'filter-dialog-title',
        ]) ?>>
            <div <?= attr([
                'class' => 'drawer__header',
            ]) ?>>
                <h2 <?= attr([
                    'id' => 'filter-dialog-title',
                    'class' => 'drawer__title',
                ]) ?>>
                    <?= t('hksagentur.facets.dialog.title') ?>
                </h2>

                <button <?= attr([
                    'class' => [
                        'drawer__close',
                        'button',
                    ],
                    'type' => 'button',
                    'command' => 'close',
                    'commandfor' => 'filter-dialog',
                    'aria-label' => t('hksagentur.facets.dialog.close'),
                ]) ?>>
                    <?php snippet('facets/icon', ['name' => 'cross']) ?>
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
