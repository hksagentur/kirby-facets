<?php /** @var \Hks\Facets\Form\Links $links */ ?>

<ul <?= attr($attr ?? [
    'role' => 'list',
]) ?>>
    <?php foreach ($links as $link): ?>
        <li>
            <a <?= attr([
                'class' => 'badge',
                'href' => $link->url(),
                'aria-label' => tt('hksagentur.facets.facet.remove', [
                    'label' => $link->label(),
                ]),
            ]) ?>>
                <?= esc($link->label()) ?>

                <svg <?= attr([
                    'viewBox' => '0 0 16 16',
                    'class' => [
                        'badge__icon',
                        'icon',
                    ],
                    'aria-hidden' => 'true'
                ]) ?>>
                    <path d="M4 4 L12 12 M12 4 L4 12" />
                </svg>
            </a>
        </li>
    <?php endforeach ?>
</ul>
