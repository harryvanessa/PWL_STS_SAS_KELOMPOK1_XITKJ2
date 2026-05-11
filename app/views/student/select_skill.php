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

            <?php 
            $majorAppsList = [
                'Desain Grafis' => ['Canva', 'Figma', 'Photoshop'],
                'Web Development' => ['Chrome DevTools', 'Git', 'VS Code'],
                'Public Speaking' => ['Canva', 'PowerPoint', 'Zoom']
            ];
            // Gunakan apps dari controller jika ada, atau dari array lokal jika diperlukan
            $apps = !empty($data['apps']) ? $data['apps'] : ((!empty($data['major']) && isset($majorAppsList[$data['major']])) ? $majorAppsList[$data['major']] : []);
            ?>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label for="app" class="form-label text-center" style="font-size:1.1rem; color:#fff;" id="app-label">
                    <?php if (!empty($data['major'])): ?>
                        Filter Aplikasi untuk Jurusan <?= htmlspecialchars($data['major']); ?>:
                    <?php else: ?>
                        Filter Aplikasi : 
                    <?php endif; ?>
                </label>
                <select name="app" id="app" class="form-select" style="padding: 1rem; font-size: 1.1rem; border-radius: 1rem;">
                    <option value="">-- Pilih Aplikasi --</option>
                    <?php if (!empty($apps)): ?>
                        <?php foreach($apps as $app): ?>
                            <?php 
                            $appName = is_array($app) ? $app['app_name'] : $app;
                            ?>
                            <option value="<?= htmlspecialchars($appName) ?>" <?= (isset($data['selectedApp']) && $data['selectedApp'] == $appName) ? 'selected' : '' ?>><?= htmlspecialchars($appName) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <input type="hidden" name="major" id="major_input" value="<?= htmlspecialchars($data['major'] ?? '') ?>">

            <button type="submit" class="btn-primary btn-block" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); font-size: 1.1rem; padding: 1rem;">
                <i class="fa-solid fa-dice" style="margin-right: 0.5rem;"></i> Gacha Mentor Sekarang
            </button>
        </form>
    </div>
</div>

<script>
(function() {
    const majorAppsList = <?= json_encode($majorAppsList); ?>;
    const skillSelect = document.getElementById('skill_id');
    const appSelect = document.getElementById('app');
    const majorInput = document.getElementById('major_input');
    const appLabel = document.getElementById('app-label');

    function populateApps(skillName) {
        appSelect.innerHTML = '<option value="">-- Pilih Aplikasi --</option>';
        if (!skillName || skillName === '-- Pilih Keterampilan --') return;

        const apps = majorAppsList[skillName] || [];
        apps.forEach(app => {
            const option = document.createElement('option');
            option.value = app;
            option.textContent = app;
            appSelect.appendChild(option);
        });

        if (apps.length > 0) {
            appLabel.textContent = 'Filter Aplikasi untuk Jurusan ' + skillName + ':';
        } else {
            appLabel.textContent = 'Filter Aplikasi :';
        }

        if (majorInput) {
            majorInput.value = skillName;
        }
    }

    skillSelect.addEventListener('change', function() {
        const selectedText = this.options[this.selectedIndex].text;
        populateApps(selectedText);
    });

    document.addEventListener('DOMContentLoaded', function() {
        const selectedText = skillSelect.options[skillSelect.selectedIndex] ? skillSelect.options[skillSelect.selectedIndex].text : '';
        if (selectedText && selectedText !== '-- Pilih Keterampilan --') {
            populateApps(selectedText);
        }
    });
})();
</script>
