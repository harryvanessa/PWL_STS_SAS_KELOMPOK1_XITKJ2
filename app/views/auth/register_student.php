<div class="zenith-auth">
    <div class="zenith-side-visual" style="background: #0f172a;">
        <div class="zenith-visual-content">
            <h1 class="zenith-hero-text">Mulai Perjalanan Akademikmu Sekarang.</h1>
            <p class="zenith-hero-sub">Dapatkan bimbingan eksklusif dari para ahli di bidangnya. Masa depan cerah dimulai dengan satu langkah kecil hari ini.</p>
            
            <div class="zenith-stats">
                <div class="stat-item">
                    <span class="stat-value">24/7</span>
                    <span class="stat-label">Dukungan Belajar</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">100%</span>
                    <span class="stat-label">Kepuasan Siswa</span>
                </div>
            </div>
        </div>
        <div class="zenith-shapes">
            <div class="shape shape-1" style="background: var(--secondary-color);"></div>
            <div class="shape shape-2"></div>
        </div>
    </div>

    <div class="zenith-side-form">
        <div class="zenith-form-container" style="max-width: 500px;">
            <div class="zenith-form-header">
                <h2>Daftar Siswa</h2>
                <p>Lengkapi data diri untuk bergabung dengan komunitas belajar kami.</p>
            </div>

            <?php Flasher::flash(); ?>

            <form action="<?= BASEURL; ?>/auth/register_student" method="post" class="zenith-form">
                <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                
                <div class="zenith-group">
                    <label>Nama Lengkap</label>
                    <div class="zenith-input-wrapper">
                        <i class="fa-solid fa-id-card"></i>
                        <input type="text" name="full_name" placeholder="Contoh: Budi Darmawan" required autocomplete="off">
                    </div>
                </div>

                <div class="zenith-grid">
                    <div class="zenith-group">
                        <label>Username</label>
                        <div class="zenith-input-wrapper">
                            <i class="fa-solid fa-at"></i>
                            <input type="text" name="username" placeholder="budidarma_99" required autocomplete="off">
                        </div>
                    </div>
                    <div class="zenith-group">
                        <label>Password</label>
                        <div class="zenith-input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" placeholder="Min 8 karakter" required>
                        </div>
                    </div>
                </div>

                <div class="zenith-grid">
                    <div class="zenith-group">
                        <label>Email Aktif</label>
                        <div class="zenith-input-wrapper">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" placeholder="budi@email.com" required>
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
                    <label>Alamat Lengkap</label>
                    <div class="zenith-input-wrapper">
                        <textarea name="address" rows="2" placeholder="Jl. Raya No. 123, Kota..." required></textarea>
                    </div>
                </div>

                <button type="submit" class="zenith-btn-primary" style="background: var(--secondary-color);">
                    Daftar Sekarang
                    <i class="fa-solid fa-rocket"></i>
                </button>

                <p class="zenith-footer-text">
                    Sudah punya akun? <a href="<?= BASEURL; ?>/auth">Masuk sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>
