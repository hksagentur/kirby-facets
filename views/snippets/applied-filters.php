<?php /** @var \Hks\Facets\Form\Facets $facets */ ?>

<?php $links ??= $facets->links() ?>
<?php $total ??= 0 ?>

<?php if ($facets->hasActive()) : ?>
    <div <?= attr(A::merge([
        'id' => 'applied-filters',
        'class' => 'applied-filters',
    ], $attr ?? [])) ?>>
        <h2 <?= attr([
            'id' => 'applied-filters-title',
            'class' => 'visually-hidden',
        ]) ?>>
            <?= t('hksagentur.facets.links.title') ?>
        </h2>

        <output <?= attr([
            'class' => 'applied-filters__count',
            'form' => $form ?? 'filters',
        ]) ?>>
            <?= tc('hksagentur.facets.applied.count', $total) ?>
        </output>

        <?= $links->toHtml([
            'class' => 'applied-filters__list',
            'aria-labelledby' => 'applied-filters-title',
        ]) ?>

        <?php if ($links->hasMultiple()): ?>
            <?= $facets->resetLink(t('hksagentur.facets.applied.reset')) ?>
        <?php endif ?>
    </div>
<?php endif ?>
