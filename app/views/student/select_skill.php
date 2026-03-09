<div class="container auth-container">
    <div class="glass-card" style="max-width: 600px;">
        <h2 class="card-title">Pilih Keterampilan Incaranmu</h2>
        
        <?php if(!empty($data['recommended'])): ?>
            <div class="alert alert-success" style="text-align: center; margin-bottom: 2rem; border-radius: 1rem;">
                <h3 style="margin-bottom: 0.5rem;">🎉 Hasil Rekomendasi</h3>
                <p>Berdasarkan jawabanmu, kamu sangat cocok belajar: <strong><?= htmlspecialchars($data['recommended']); ?></strong></p>
                <p class="text-sm mt-3 text-muted">Abaikan saran jika kamu ingin memilih yang lain.</p>
            </div>
        <?php endif; ?>

        <form action="<?= BASEURL; ?>/student/gacha" method="post">
            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="skill_id" class="form-label text-center" style="font-size:1.1rem; color:#fff;">Pilih bidang yang ingin kamu kuasai:</label>
                <select name="skill_id" id="skill_id" class="form-select" style="padding: 1rem; font-size: 1.1rem; border-radius: 1rem;" required>
                    <option value="" disabled selected>-- Pilih Keterampilan --</option>
                    <?php foreach($data['skills'] as $skill): ?>
                        <option value="<?= $skill['id'] ?>" <?= (isset($data['recommended']) && $data['recommended'] == $skill['name']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($skill['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-primary btn-block" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); font-size: 1.1rem; padding: 1rem;">
                <i class="fa-solid fa-dice" style="margin-right: 0.5rem;"></i> Gacha Mentor Sekarang
            </button>
        </form>
    </div>
</div>
