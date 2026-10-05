<?php /** @var \Hks\Facets\Form\Facets $facets */ ?>

<?php $links ??= $facets->links() ?>
<?php $total ??= 0 ?>

<section <?= attr(A::merge([
    'class' => 'applied-filters',
    'aria-labelledby' => 'applied-filters-title',
], $attr ?? [])) ?>>
    <h2 <?= attr([
        'id' => 'applied-filters-title',
        'class' => 'visually-hidden',
    ]) ?>>
        <?= t('hksagentur.facets.links.title') ?>
    </h2>

    <?php if ($total > 0): ?>
        <output <?= attr([
            'class' => 'applied-filters__count',
            'form' => $form ?? 'filters',
        ]) ?>>
            <?= tc('hksagentur.facets.applied.count', $total) ?>
        </output>
    <?php endif ?>

    <?= $links->toHtml([
        'class' => 'applied-filters__list',
    ]) ?>

    <?php if ($links->hasMultiple()): ?>
        <?= $facets->resetLink(t('hksagentur.facets.applied.reset')) ?>
    <?php endif ?>
</section>
