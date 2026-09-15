<?php $isHighlighted = !empty($highlight); ?>
<article class="feature-card<?= $isHighlighted ? ' feature-card--highlight' : '' ?>" data-reveal>
    <div class="feature-card__icon" aria-hidden="true">
        <i class="fas <?= esc($icon ?? 'fa-cube') ?>"></i>
    </div>
    <h3><?= esc($title ?? 'Fitur') ?></h3>
    <p><?= esc($description ?? '') ?></p>
</article>
