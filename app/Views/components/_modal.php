<?php
/**
 * Modal component (Atomic - organism).
 *
 * @param string $id
 * @param string $title
 * @param string $body
 * @param string $footer Optional HTML.
 */
$modalId = $id ?? 'modal-default';
$modalTitle = $title ?? 'Dialog';
$modalBody = $body ?? '';
$modalFooter = $footer ?? '';
?>
<div
    id="<?= esc($modalId) ?>"
    class="modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="<?= esc($modalId) ?>-title"
    aria-describedby="<?= esc($modalId) ?>-desc"
    aria-hidden="true"
    data-modal
>
    <div class="modal__backdrop" data-modal-backdrop></div>
    <div class="modal__dialog" data-modal-dialog>
        <div class="modal__header">
            <h2 id="<?= esc($modalId) ?>-title" class="modal__title"><?= esc($modalTitle) ?></h2>
            <button type="button" class="modal__close" data-modal-close aria-label="Tutup dialog">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
        <div id="<?= esc($modalId) ?>-desc" class="modal__body">
            <?= $modalBody ?>
        </div>
        <?php if ($modalFooter): ?>
            <div class="modal__footer">
                <?= $modalFooter ?>
            </div>
        <?php endif; ?>
    </div>
</div>
