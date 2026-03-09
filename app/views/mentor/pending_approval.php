<div class="container auth-container">
    <div class="glass-card" style="text-align: center; max-width: 500px;">
        <div style="font-size: 4rem; color: <?= $data['profile']['status'] == 'rejected' ? '#ef4444' : '#fbbf24' ?>; margin-bottom: 1rem;">
            <?php if($data['profile']['status'] == 'rejected'): ?>
                <i class="fa-solid fa-circle-xmark"></i>
            <?php else: ?>
                <i class="fa-solid fa-hourglass-half"></i>
            <?php endif; ?>
        </div>
        <h2 class="card-title" style="margin-bottom: 0.5rem;">
            <?= $data['profile']['status'] == 'rejected' ? 'Pendaftaran Ditolak' : 'Menunggu Persetujuan Admin' ?>
        </h2>
        <p class="text-muted" style="margin-bottom: 1.5rem;">Halo, <strong><?= htmlspecialchars($data['profile']['full_name']); ?></strong>! Pendaftaran mentor Anda sedang ditinjau oleh Admin aplikasi. Harap periksa kembali secara berkala.</p>
        
        <div style="background: rgba(0,0,0,0.2); border-radius: 0.75rem; padding: 1rem; margin-bottom: 1.5rem; text-align: left;">
            <p class="text-sm"><strong>Bidang:</strong> <?= htmlspecialchars($data['profile']['skill_name']); ?></p>
            <?php if($data['profile']['status'] == 'rejected'): ?>
                <p class="text-sm mt-3"><strong>Status:</strong> <span class="badge badge-danger">Ditolak</span></p>
                <div style="margin-top: 1rem; padding: 1rem; border-left: 4px solid #ef4444; background: rgba(239, 68, 68, 0.1);">
                    <p class="text-sm" style="margin: 0;"><strong>Alasan Penolakan:</strong><br><?= htmlspecialchars($data['profile']['feedback']); ?></p>
                </div>
            <?php else: ?>
                <p class="text-sm mt-3"><strong>Status:</strong> <span class="badge badge-pending">Pending</span></p>
            <?php endif; ?>
        </div>

        <a href="<?= BASEURL; ?>/auth/logout" class="btn-secondary">Keluar</a>
    </div>
</div>
