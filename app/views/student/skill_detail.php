<!-- SKILL DETAIL PAGE -->
<?php
$skill   = $data['skill'];
$uid     = $_SESSION['user']['id'];
$isOwner = $skill['student_user_id'] == $uid;

$levelColors = ['beginner' => '#10b981', 'intermediate' => '#f59e0b', 'advanced' => '#e55f4f'];
$levelLabels = ['beginner' => 'Pemula', 'intermediate' => 'Menengah', 'advanced' => 'Mahir'];
$lc = $levelColors[$skill['level']] ?? '#64748b';
$ll = $levelLabels[$skill['level']] ?? $skill['level'];
?>
<div class="container" style="max-width: 860px; padding-bottom: 4rem;">

    <!-- Back Button -->
    <a href="<?= BASEURL; ?>/student/skill_exchange" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.9rem; text-decoration: none; margin-bottom: 2rem; transition: color 0.2s;"
       onmouseover="this.style.color='white'" onmouseout="this.style.color=''">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
    </a>

    <?php Flasher::flash(); ?>

    <div class="glass-card" style="padding: 2.5rem;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid var(--border-color);">
            <div>
                <span class="badge badge-primary" style="font-size: 0.9rem; margin-bottom: 0.75rem; display: inline-block;">
                    <i class="fa-solid fa-tag"></i> <?= htmlspecialchars($skill['skill_name']); ?>
                </span>
                <h1 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 0.5rem;">
                    Penawaran Keterampilan Siswa
                </h1>
                <span style="background: <?= $lc; ?>22; color: <?= $lc; ?>; border: 1px solid <?= $lc; ?>44; padding: 4px 14px; border-radius: 99px; font-size: 0.85rem; font-weight: 700;">
                    <i class="fa-solid fa-signal"></i> Level: <?= $ll; ?>
                </span>
            </div>
            <div style="text-align: right; color: var(--text-muted); font-size: 0.85rem;">
                <i class="fa-solid fa-clock"></i>
                Ditawarkan <?= date('d M Y', strtotime($skill['created_at'])); ?>
            </div>
        </div>

        <!-- Student Profile -->
        <div style="display: flex; align-items: center; gap: 1.25rem; margin-bottom: 2rem; padding: 1.5rem; background: rgba(79,70,229,0.08); border-radius: 1rem; border: 1px solid rgba(79,70,229,0.2);">
            <div style="width: 4rem; height: 4rem; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), #6d28d9); display: flex; align-items: center; justify-content: center; font-weight: 800; color: white; font-size: 1.5rem; flex-shrink: 0;">
                <?= strtoupper(mb_substr($skill['full_name'], 0, 1)); ?>
            </div>
            <div>
                <p style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.25rem;"><?= htmlspecialchars($skill['full_name']); ?></p>
                <p style="color: var(--text-muted); font-size: 0.9rem;">@<?= htmlspecialchars($skill['username']); ?></p>
                <?php if ($skill['email']): ?>
                    <p style="color: var(--text-muted); font-size: 0.85rem;">
                        <i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($skill['email']); ?>
                    </p>
                <?php endif; ?>
            </div>
            <?php if ($isOwner): ?>
                <div style="margin-left: auto;">
                    <span class="badge badge-success"><i class="fa-solid fa-circle-check"></i> Ini milikmu</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Description -->
        <?php if ($skill['description']): ?>
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; color: var(--text-main);">
                <i class="fa-solid fa-quote-left" style="color: var(--primary-color); margin-right: 0.5rem;"></i>
                Tentang Keterampilan Ini
            </h3>
            <p style="color: var(--text-muted); line-height: 1.7; font-size: 0.95rem; background: rgba(255,255,255,0.03); padding: 1.25rem; border-radius: 0.875rem; border: 1px solid var(--border-color);">
                <?= nl2br(htmlspecialchars($skill['description'])); ?>
            </p>
        </div>
        <?php endif; ?>

        <!-- Skill Category Info -->
        <?php if ($skill['skill_desc']): ?>
        <div style="margin-bottom: 2rem; padding: 1.25rem; background: rgba(16,185,129,0.08); border-radius: 1rem; border: 1px solid rgba(16,185,129,0.2);">
            <h4 style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.08em; color: #10b981; margin-bottom: 0.5rem;">
                <i class="fa-solid fa-circle-info"></i> Tentang Bidang <?= htmlspecialchars($skill['skill_name']); ?>
            </h4>
            <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;"><?= htmlspecialchars($skill['skill_desc']); ?></p>
        </div>
        <?php endif; ?>

        <!-- CTA Section -->
        <?php if (!$isOwner): ?>
        <div style="padding: 2rem; background: linear-gradient(135deg, rgba(79,70,229,0.12), rgba(109,40,217,0.08)); border-radius: 1rem; border: 1px solid rgba(79,70,229,0.25); text-align: center;">
            <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Tertarik Belajar dari <?= htmlspecialchars($skill['full_name']); ?>?</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.95rem;">Kirim permintaan pertukaran keterampilan. Mereka akan menerima atau menolak permintaanmu.</p>
            <button onclick="document.getElementById('modal-request').style.display='flex'" class="zenith-btn-primary" style="display: inline-flex; max-width: 320px;">
                <i class="fa-solid fa-handshake"></i> Ajukan Pertukaran
            </button>
        </div>
        <?php else: ?>
        <div style="padding: 1.5rem; background: rgba(255,255,255,0.03); border-radius: 1rem; border: 1px solid var(--border-color); text-align: center;">
            <p style="color: var(--text-muted);">Ini adalah penawaran keterampilanmu sendiri.</p>
            <a href="<?= BASEURL; ?>/student/delete_skill/<?= $skill['id']; ?>"
               onclick="return confirm('Dihapus?')"
               class="btn-small btn-danger" style="margin-top: 0.75rem; display: inline-flex; gap: 0.5rem; align-items: center;">
                <i class="fa-solid fa-trash"></i> Hapus Penawaran Ini
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- ═══ MODAL: REQUEST EXCHANGE ══════════════════════════════════════════════ -->
<?php if (!$isOwner): ?>
<div id="modal-request" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.75); z-index: 5000; align-items: center; justify-content: center; padding: 1rem;">
    <div class="glass-card" style="width: 100%; max-width: 480px; margin: 0; position: relative;">
        <button onclick="document.getElementById('modal-request').style.display='none'"
                style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer; line-height: 1;">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2 class="card-title" style="font-size: 1.4rem; margin-bottom: 0.5rem;">Ajukan Pertukaran</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem;">
            Kamu ingin belajar <strong><?= htmlspecialchars($skill['skill_name']); ?></strong>
            dari <strong><?= htmlspecialchars($skill['full_name']); ?></strong>.
        </p>

        <form action="<?= BASEURL; ?>/student/request_exchange" method="post" class="zenith-form">
            <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
            <input type="hidden" name="student_skill_id" value="<?= $skill['id']; ?>">
            <input type="hidden" name="provider_id" value="<?= $skill['student_user_id']; ?>">

            <div class="zenith-group">
                <label>Pesan untuk <?= htmlspecialchars($skill['full_name']); ?> (opsional)</label>
                <div class="zenith-input-wrapper">
                    <textarea name="message" rows="4"
                        placeholder="Ceritakan sedikit tentang dirimu dan kenapa kamu ingin belajar skill ini..."></textarea>
                </div>
            </div>

            <button type="submit" class="zenith-btn-primary">
                <i class="fa-solid fa-paper-plane"></i> Kirim Permintaan
            </button>
        </form>
    </div>
</div>
<?php endif; ?>
