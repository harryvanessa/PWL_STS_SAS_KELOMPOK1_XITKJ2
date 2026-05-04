<div class="zenith-auth">
    <div class="zenith-side-visual" style="background: #0f172a;">
        <div class="zenith-visual-content">
            <h1 class="zenith-hero-text">Pilih Jurusan dan Aplikasi</h1>
            <p class="zenith-hero-sub">Setelah mendaftar, pilih jurusan favoritmu lalu tunjukkan aplikasi yang kamu kuasai.</p>

            <div class="zenith-stats">
                <div class="stat-item">
                    <span class="stat-value">4</span>
                    <span class="stat-label">Jurusan Tersedia</span>
                </div>
                <div class="stat-item">
                    <span class="stat-value">8+</span>
                    <span class="stat-label">Aplikasi Pilihan</span>
                </div>
            </div>
        </div>
        <div class="zenith-shapes">
            <div class="shape shape-1" style="background: var(--secondary-color);"></div>
            <div class="shape shape-2"></div>
        </div>
    </div>

    <div class="zenith-side-form">
        <div class="zenith-form-container" style="max-width: 520px;">
            <div class="zenith-form-header">
                <h2>Pencarian Jurusan</h2>
                <p>Gunakan filter jurusan dan pilih aplikasi yang kamu kuasai. Setelah selesai, lanjutkan ke halaman login.</p>
            </div>

            <?php Flasher::flash(); ?>

            <form action="<?= BASEURL; ?>/auth/major_search" method="post" class="zenith-form" id="major-search-form">
                <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">

                <div class="zenith-group">
                    <label>Jurusan</label>
                    <div class="zenith-input-wrapper">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <select name="major" id="major" required>
                            <option value="" disabled selected>-- Pilih Jurusan --</option>
                            <?php foreach ($data['majors'] as $major => $info): ?>
                                <option value="<?= htmlspecialchars($major); ?>" <?= $data['selectedMajor'] === $major ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($major); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="zenith-group" id="app-group" style="display: <?= empty($data['selectedMajor']) ? 'none' : 'block'; ?>; opacity: <?= empty($data['selectedMajor']) ? '0.7' : '1'; ?>; transition: opacity 0.3s ease;">
                    <label>Aplikasi yang Dikuasai</label>
                    <div class="zenith-input-wrapper">
                        <i class="fa-solid fa-laptop-code"></i>
                        <select name="app" id="app" required>
                            <option value="" disabled selected>-- Pilih Aplikasi --</option>
                        </select>
                    </div>
                    <p class="text-muted" style="margin-top: 0.5rem;">Contoh: Figma, Canva, Photoshop untuk jurusan Design Grafis.</p>
                </div>

                <button type="submit" class="zenith-btn-primary" style="background: var(--secondary-color);">
                    Lanjut ke Login
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

                <p class="zenith-footer-text">
                    Sudah punya akun? <a href="<?= BASEURL; ?>/auth">Masuk sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>

<script>
    const majorSelect = document.getElementById('major');
    const appSelect = document.getElementById('app');
    const appGroup = document.getElementById('app-group');
    const appOptions = <?= json_encode(array_map(function($info) { return $info['apps']; }, $data['majors'])); ?>;
    const selectedMajor = <?= json_encode($data['selectedMajor']); ?>;
    const selectedApp = <?= json_encode($data['selectedApp']); ?>;

    function renderAppOptions(major) {
        while (appSelect.firstChild) {
            appSelect.removeChild(appSelect.firstChild);
        }

        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = '-- Pilih Aplikasi --';
        appSelect.appendChild(defaultOption);

        if (!major || !appOptions[major]) {
            return;
        }

        appOptions[major].forEach(app => {
            const option = document.createElement('option');
            option.value = app;
            option.textContent = app;
            if (app === selectedApp) {
                option.selected = true;
            }
            appSelect.appendChild(option);
        });
    }

    majorSelect.addEventListener('change', function () {
        if (!this.value) {
            appGroup.style.display = 'none';
            return;
        }
        renderAppOptions(this.value);
        appGroup.style.display = 'block';
        appGroup.style.opacity = '1';
    });

    if (selectedMajor) {
        renderAppOptions(selectedMajor);
    }
</script>
