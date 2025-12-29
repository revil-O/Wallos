<div class="info-box" style="padding: 1rem; border: 2px solid var(--main-color); border-radius: 8px; margin: 1rem 0; background-color: var(--accent-color);">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <?php if (isset($icon)): ?>
            <i class="fa <?= $this->escape($icon) ?>" style="font-size: 2rem; color: var(--main-color);"></i>
        <?php endif; ?>
        <div style="flex: 1;">
            <?php if (isset($title)): ?>
                <h3 style="margin: 0 0 0.5rem 0;"><?= $this->escape($title) ?></h3>
            <?php endif; ?>
            <?php if (isset($content)): ?>
                <p style="margin: 0;"><?= $this->escape($content) ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
