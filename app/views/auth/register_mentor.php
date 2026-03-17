<div class="zenith-auth">
    <div class="zenith-side-visual" style="background: #0f172a;">
        <div class="zenith-visual-content">
            <h1 class="zenith-hero-text">Bergabung Sebagi Mentor Ahli.</h1>
            <p class="zenith-hero-sub">Bagikan ilmu, bimbing generasi masa depan, dan bangun profil profesional Anda di platform kami. Pendaftaran Anda akan ditinjau secara eksklusif oleh tim Admin.</p>
            
            <div class="zenith-stats">
                <div class="stat-item">
                    <span class="stat-value">500+</span>
                    <span class="stat-label">Mentor Bergabung</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">Eksklusif</span>
                    <span class="stat-label">Komunitas Ahli</span>
                </div>
            </div>
        </div>
        <div class="zenith-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2" style="background: var(--primary-color); opacity: 0.1;"></div>
        </div>
    </div>

    <div class="zenith-side-form">
        <div class="zenith-form-container" style="max-width: 550px;">
            <div class="zenith-form-header">
                <h2>Pendaftaran Mentor</h2>
                <p>Isi formulir pendaftaran profesional untuk segera bergabung.</p>
            </div>

            <?php Flasher::flash(); ?>

            <form action="<?= BASEURL; ?>/auth/register_mentor" method="post" class="zenith-form">
                <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                
                <div class="zenith-group">
                    <label>Nama Lengkap & Gelar</label>
                    <div class="zenith-input-wrapper">
                        <i class="fa-solid fa-user-doctor"></i>
                        <input type="text" name="full_name" placeholder="Contoh: Dr. Budi Santoso, M.T." required autocomplete="off">
                    </div>
                </div>

                <div class="zenith-grid">
                    <div class="zenith-group">
                        <label>Username Login</label>
                        <div class="zenith-input-wrapper">
                            <i class="fa-solid fa-at"></i>
                            <input type="text" name="username" placeholder="user_id" required autocomplete="off">
                        </div>
                    </div>
                    <div class="zenith-group">
                        <label>Password</label>
                        <div class="zenith-input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" placeholder="Kata sandi" required>
                        </div>
                    </div>
                </div>

                <div class="zenith-grid">
                    <div class="zenith-group">
                        <label>Email Profesional</label>
                        <div class="zenith-input-wrapper">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" placeholder="mentor@email.com" required>
                        </div>
                    </div>
                    <div class="zenith-group">
                        <label>WhatsApp</label>
                        <div class="zenith-input-wrapper">
                            <i class="fab fa-whatsapp"></i>
                            <input type="text" name="phone" placeholder="0812xxxxxxx" required>
                        </div>
                    </div>
                </div>

                <div class="zenith-group">
                    <label>Bidang Keahlian Utama</label>
                    <div class="zenith-input-wrapper">
                        <select name="skill_id" required>
                            <option value="" disabled selected>-- Pilih Keterampilan --</option>
                            <?php foreach($data['skills'] as $skill): ?>
                                <option value="<?= $skill['id'] ?>"><?= htmlspecialchars($skill['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="zenith-group">
                    <label>Pengalaman Singkat</label>
                    <div class="zenith-input-wrapper">
                        <textarea name="experience" rows="2" placeholder="Ceritakan latar belakang profesional Anda..." required></textarea>
                    </div>
                </div>

                <button type="submit" class="zenith-btn-primary">
                    Ajukan Pendaftaran Mentor
                    <i class="fa-solid fa-check-circle"></i>
                </button>

                <p class="zenith-footer-text">
                    Sudah punya akun? <a href="<?= BASEURL; ?>/auth">Masuk sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>
