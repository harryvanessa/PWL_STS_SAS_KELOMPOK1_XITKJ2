<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <div class="glass-card" style="background: transparent; border: none; padding: 0; box-shadow: none;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; margin: 0;"><i class="fa-regular fa-comments"></i> Semua Ulasan Siswa</h1>
            <a href="<?= BASEURL; ?>/mentor" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.5rem; border-radius: 2rem; text-decoration: none;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <?php if(empty($data['comments'])): ?>
            <div class="glass-card" style="text-align: center; padding: 4rem;">
                <i class="fa-solid fa-comment-slash" style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.5; color: var(--text-muted);"></i>
                <p class="text-muted" style="font-size: 1.2rem;">Belum ada komentar dari siswa.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1.5rem;">
                <?php foreach($data['comments'] as $comment): ?>
                    <div class="glass-card" style="padding: 1.5rem; display: flex; flex-direction: column; transition: transform 0.2s ease;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div style="width: 35px; height: 35px; border-radius: 50%; background: var(--secondary-color); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    <?= strtoupper(substr($comment['full_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <strong style="color: #60a5fa; font-size: 1.1rem; display: block;"><?= htmlspecialchars($comment['full_name']); ?></strong>
                                    <span style="font-size: 0.8rem; color: var(--text-muted);">@<?= htmlspecialchars($comment['username']); ?></span>
                                </div>
                            </div>
                            <span style="font-size: 0.85rem; color: var(--text-muted);"><i class="fa-regular fa-clock"></i> <?= date('d M Y', strtotime($comment['created_at'])); ?></span>
                        </div>
                        <p style="margin: 0; font-size: 1.05rem; line-height: 1.6; flex-grow: 1; color: var(--text-main);"><?= nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>
