<div class="zenith-auth">
    <div class="zenith-side-visual">
        <div class="zenith-visual-content">
            <div class="zenith-logo">
                <i class="fas fa-graduation-cap"></i>
                <span>MentorExpert</span>
            </div>
            <h1 class="zenith-hero-text">Tingkatkan Potensi Bersama Mentor Terbaik.</h1>
            <p class="zenith-hero-sub">Masa depan cerah dimulai dari bimbingan yang tepat. Bergabunglah dengan ribuan mahasiswa lainnya hari ini.</p>
            
            <div class="zenith-stats">
                <div class="stat-item">
                    <span class="stat-value">500+</span>
                    <span class="stat-label">Mentor Ahli</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">10k+</span>
                    <span class="stat-label">Siswa Aktif</span>
                </div>
            </div>
        </div>
        <div class="zenith-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
        </div>
    </div>

    <div class="zenith-side-form">
        <div class="zenith-form-container">
            <div class="zenith-form-header">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk untuk melanjutkan akses platform.</p>
            </div>

            <?php Flasher::flash(); ?>

            <form action="<?= BASEURL; ?>/auth/login" method="post" class="zenith-form">
                <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                
                <div class="zenith-group">
                    <label>Username</label>
                    <div class="zenith-input-wrapper">
                        <i class="far fa-user"></i>
                        <input type="text" name="username" placeholder="Masukkan username Anda" required autocomplete="off">
                    </div>
                </div>

                <div class="zenith-group">
                    <div class="zenith-label-row">
                        <label>Password</label>
                        <a href="#">Lupa password?</a>
                    </div>
                    <div class="zenith-input-wrapper">
                        <i class="far fa-lock-alt"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="zenith-options">
                    <label class="zenith-checkbox">
                        <input type="checkbox" name="remember">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="zenith-btn-primary">
                    Masuk Sekarang
                    <i class="fas fa-arrow-right"></i>
                </button>

                <div class="zenith-divider">
                    <span>Atau masuk dengan</span>
                </div>

                <div class="zenith-social">
                    <button type="button" class="zenith-social-btn">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google">
                        Google
                    </button>
                    <button type="button" class="zenith-social-btn">
                        <i class="fab fa-github"></i>
                        GitHub
                    </button>
                </div>

                <p class="zenith-footer-text">
                    Belum punya akun? <a href="<?= BASEURL; ?>/auth/register_student">Daftar sebagai siswa</a>
                </p>
            </form>
        </div>
    </div>
</div>
