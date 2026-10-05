<?php /** @var \Hks\Facets\Form\Links $links */ ?>

<ul <?= attr(A::merge([
    'role' => 'list',
], $attr ?? [])) ?>>
    <?php foreach ($links as $link): ?>
        <li>
            <?= $link ?>
        </li>
    <?php endforeach ?>
</ul>
