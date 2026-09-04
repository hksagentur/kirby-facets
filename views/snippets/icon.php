<?php if (kirby()->option('debug')): ?>
    <?php trigger_error(
        sprintf('[hksagentur/facets] No `facets/icon` snippet defined for icon "%s". Add site/snippets/facets/icon.php to render it.', $name),
        E_USER_NOTICE,
    ) ?>
<?php endif ?>

<span <?= attr(A::merge([
        'class' => 'icon',
        'data-icon' => $name,
        'aria-hidden' => 'true',
    ], $attr ?? [])) ?>></span>
