<?php /** @var \Hks\Facets\Form\Links $items */ ?>

<ul <?= attr($attr ?? [
    'role' => 'list',
]) ?>>
    <?php foreach ($items as $item): ?>
        <li>
            <?= $item ?>
        </li>
    <?php endforeach ?>
</ul>
