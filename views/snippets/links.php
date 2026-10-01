<?php /** @var \Hks\Facets\Form\Links $links */ ?>

<ul <?= attr($attr ?? [
    'role' => 'list',
]) ?>>
    <?php foreach ($links as $link): ?>
        <li>
            <?= $link ?>
        </li>
    <?php endforeach ?>
</ul>
