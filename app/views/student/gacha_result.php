<div class="container auth-container">
    <div class="glass-card" style="max-width: 600px; text-align: center;">
        
        <?php if($data['mentor']): ?>
            <h2 class="card-title" style="margin-bottom: 0.5rem;">🎉 Mentor Ditemukan!</h2>
            <p class="text-muted" style="margin-bottom: 2rem;">Sistem telah mencocokkan Anda dengan spesialis <strong><?= htmlspecialchars($data['skill']['name']); ?></strong>.</p>
            
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); padding: 2rem; border-radius: 1rem; margin-bottom: 2rem;">
                <div style="font-size: 4rem; color: var(--secondary-color); margin-bottom: 1rem;">
                    <i class="fa-solid fa-user-astronaut"></i>
                </div>
                <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($data['mentor']['full_name']); ?></h3>
                <p class="text-sm text-muted" style="margin-bottom: 1rem;">@<?= htmlspecialchars($data['mentor']['username']); ?></p>
                
                <div style="text-align: left; background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 0.75rem; margin-bottom: 1rem;">
                    <strong>Pengalaman:</strong><br>
                    <span class="text-muted text-sm"><?= htmlspecialchars($data['mentor']['experience']); ?></span>
                </div>
                
                <a href="<?= BASEURL; ?>/student/mentor_comments/<?= $data['mentor']['user_id']; ?>/<?= $data['skill']['id']; ?>" class="btn-secondary" style="display: inline-block; padding: 0.5rem 1rem; font-size: 0.9rem; border-radius: 2rem;">
                    <i class="fa-regular fa-comments"></i> Lihat Komentar
                </a>
            </div>

            <!-- Form Ajukan Jadwal -->
            <form action="<?= BASEURL; ?>/student/schedule" method="post" style="text-align: left;">
                <input type="hidden" name="mentor_user_id" value="<?= $data['mentor']['user_id']; ?>">
                <input type="hidden" name="skill_id" value="<?= $data['skill']['id']; ?>">
                
                <h4 style="margin-bottom: 1rem;">Ajukan Jadwal Bimbingan</h4>
                <div class="form-group">
                    <label for="session_date" class="form-label">Pilih Tanggal & Waktu</label>
                    <input type="datetime-local" name="session_date" id="session_date" class="form-control" required style="color-scheme: dark;">
                </div>
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="notes" class="form-label">Catatan untuk Mentor (Topik Spesifik)</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Contoh: Saya ingin belajar cara membuat REST API..." required></textarea>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <a href="<?= BASEURL; ?>/student/select_skill" class="btn-secondary" style="flex: 1; text-align: center; display: flex; align-items: center; justify-content: center;">Batal / Gacha Ulang</a>
                    <button type="submit" class="btn-primary" style="flex: 1; padding: 0.875rem;">Ajukan Jadwal</button>
                </div>
            </form>

        <?php else: ?>
            <div style="font-size: 4rem; color: var(--text-muted); margin-bottom: 1rem;">
                <i class="fa-regular fa-face-frown-open"></i>
            </div>
            <h2 class="card-title">Waduh!</h2>
            <p class="text-muted" style="margin-bottom: 2rem;">Belum ada mentor yang tersedia atau disetujui untuk bidang <strong><?= htmlspecialchars($data['skill']['name']); ?></strong> saat ini.</p>
            <a href="<?= BASEURL; ?>/student/select_skill" class="btn-primary" style="display: inline-block;">Pilih Keterampilan Lain</a>
        <?php endif; ?>

    </div>
</div>
