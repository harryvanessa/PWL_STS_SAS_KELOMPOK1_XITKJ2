<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">

    <div style="margin-bottom: 1.5rem;">
        <a href="<?= BASEURL; ?>/admin" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 2rem; text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="glass-card" style="max-width: 1000px; width: 100%; margin: 0 auto; padding: 3rem;">

        <?php Flasher::flash(); ?>

        <!-- Header Profil Siswa -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1.5rem; gap: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="font-size: 4.5rem; color: var(--secondary-color);">
                    <i class="fa-solid fa-user-graduate"></i>
                </div>
                <div>
                    <h2 style="font-size: 2.2rem; margin: 0;"><?= htmlspecialchars($data['student']['full_name']); ?></h2>
                    <p class="text-muted" style="margin: 0 0 0.4rem 0; font-size: 1.1rem;">@<?= htmlspecialchars($data['student']['username']); ?></p>
                    <p class="text-muted" style="margin: 0; font-size: 0.95rem;">
                        <i class="fa-regular fa-envelope"></i> <?= htmlspecialchars($data['student']['email'] ?? '-'); ?>
                        &nbsp;|&nbsp;
                        <i class="fa-solid fa-phone"></i> <?= htmlspecialchars($data['student']['phone'] ?? '-'); ?>
                    </p>
                </div>
            </div>
            <div>
                <a href="<?= BASEURL; ?>/admin/delete_student/<?= $data['student']['user_id']; ?>"
                   class="btn-danger"
                   style="padding: 0.75rem 1.5rem; border-radius: 2rem; text-decoration: none; display: inline-block;"
                   onclick="return confirm('Hapus akun siswa <?= htmlspecialchars(addslashes($data['student']['full_name'])); ?>? Semua data siswa akan ikut terhapus dan tidak bisa dikembalikan.');">
                    <i class="fa-solid fa-user-minus"></i> Hapus Akun Siswa
                </a>
            </div>
        </div>

        <!-- Info Siswa -->
        <div style="margin-bottom: 2.5rem; background: rgba(0,0,0,0.15); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--glass-border);">
            <h4 style="margin-bottom: 0.75rem; font-size: 1.1rem; color: #60a5fa;">Info Siswa:</h4>
            <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
                <div>
                    <span class="text-muted" style="font-size: 0.85rem;">Alamat</span>
                    <p style="margin: 0.25rem 0 0 0; font-size: 1rem;"><?= htmlspecialchars($data['student']['address'] ?? '-'); ?></p>
                </div>
                <div>
                    <span class="text-muted" style="font-size: 0.85rem;">Minat / Interest</span>
                    <p style="margin: 0.25rem 0 0 0; font-size: 1rem;"><?= htmlspecialchars($data['student']['interest'] ?? 'Belum diisi'); ?></p>
                </div>
            </div>
        </div>

        <!-- Carikan Mentor untuk Siswa -->
        <div style="margin-bottom: 2.5rem; background: rgba(0,0,0,0.15); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--glass-border);">
            <h4 style="margin-bottom: 1rem; font-size: 1.1rem;">Carikan Mentor untuk Siswa Ini</h4>
            <p class="text-muted" style="margin-bottom: 1rem; font-size: 0.9rem;">Admin dapat langsung menetapkan mentor untuk siswa. Sesi akan otomatis berstatus <strong>confirmed</strong>.</p>
            <form action="<?= BASEURL; ?>/admin/assign_mentor" method="post">
                <input type="hidden" name="student_id" value="<?= $data['student']['user_id']; ?>">
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: flex-end;">
                    <div class="form-group" style="flex: 1; min-width: 180px; margin-bottom: 0;">
                        <label class="form-label">Pilih Mentor:</label>
                        <select name="mentor_user_id" class="form-control" required onchange="updateSkillFromMentor(this)">
                            <option value="">-- Pilih Mentor --</option>
                            <?php foreach($data['approved_mentors'] as $m): ?>
                                <option value="<?= $m['user_id']; ?>" data-skill-id="<?= $m['skill_id'] ?? ''; ?>">
                                    <?= htmlspecialchars($m['full_name']); ?> (<?= htmlspecialchars($m['skill_name']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 160px; margin-bottom: 0;">
                        <label class="form-label">Keahlian / Skill:</label>
                        <select name="skill_id" id="skillSelectAssign" class="form-control" required>
                            <option value="">-- Pilih Skill --</option>
                            <?php foreach($data['skills'] as $sk): ?>
                                <option value="<?= $sk['id']; ?>"><?= htmlspecialchars($sk['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 160px; margin-bottom: 0;">
                        <label class="form-label">Tanggal Sesi:</label>
                        <input type="datetime-local" name="session_date" class="form-control" required>
                    </div>
                    <div class="form-group" style="flex: 2; min-width: 200px; margin-bottom: 0;">
                        <label class="form-label">Catatan (opsional):</label>
                        <input type="text" name="notes" class="form-control" placeholder="Catatan sesi...">
                    </div>
                    <button type="submit" class="btn-primary" style="padding: 0.75rem 1.5rem;">Tetapkan Mentor</button>
                </div>
            </form>
        </div>

        <!-- Riwayat Sesi Bimbingan -->
        <h3 style="margin-bottom: 1rem; font-size: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
            <i class="fa-solid fa-calendar-check"></i> Riwayat Sesi Bimbingan
        </h3>

        <?php if(empty($data['sessions'])): ?>
            <div style="text-align: center; padding: 2rem 1rem; color: var(--text-muted); background: rgba(0,0,0,0.1); border-radius: 1.25rem; margin-bottom: 2.5rem;">
                <i class="fa-regular fa-calendar-xmark" style="font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.5; display: block;"></i>
                <p style="margin: 0;">Siswa ini belum memiliki riwayat sesi bimbingan.</p>
            </div>
        <?php else: ?>
            <div class="table-container" style="margin-top: 0; margin-bottom: 2.5rem;">
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Mentor</th>
                            <th>Keahlian</th>
                            <th>Catatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['sessions'] as $s): ?>
                        <tr>
                            <td><?= date('d M Y, H:i', strtotime($s['session_date'])); ?></td>
                            <td style="font-weight: 500;"><?= htmlspecialchars($s['mentor_name']); ?></td>
                            <td><?= htmlspecialchars($s['skill_name']); ?></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?= htmlspecialchars($s['notes'] ?? '-'); ?></td>
                            <td>
                                <?php if($s['status'] == 'pending'): ?>
                                    <span class="badge badge-pending">Menunggu</span>
                                <?php elseif($s['status'] == 'confirmed'): ?>
                                    <span class="badge badge-success">Dikonfirmasi</span>
                                <?php elseif($s['status'] == 'rejected'): ?>
                                    <span class="badge badge-danger">Ditolak</span>
                                <?php else: ?>
                                    <span class="badge" style="background: rgba(107,114,128,0.3); color: #9ca3af;">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Komentar yang Ditulis Siswa Ini -->
        <h3 style="margin-bottom: 0.5rem; font-size: 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
            <i class="fa-regular fa-comment-dots"></i> Komentar yang Ditulis Siswa Ini
        </h3>
        <p class="text-muted" style="margin-bottom: 1.5rem;">Hanya menampilkan komentar dari siswa <strong><?= htmlspecialchars($data['student']['full_name']); ?></strong> ke berbagai mentor.</p>

        <?php if(empty($data['student_comments'])): ?>
            <div style="text-align: center; padding: 2.5rem 1rem; color: var(--text-muted); background: rgba(0,0,0,0.1); border-radius: 1.25rem;">
                <i class="fa-solid fa-comment-slash" style="font-size: 2.5rem; margin-bottom: 0.75rem; opacity: 0.5; display: block;"></i>
                <p style="margin: 0;">Siswa ini belum pernah mengirimkan komentar untuk mentor manapun.</p>
            </div>
        <?php else: ?>
            <?php foreach($data['student_comments'] as $c): ?>
                <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); padding: 1.5rem; border-radius: 1.25rem; margin-bottom: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 0.5rem;">
                        <div>
                            <span class="text-muted" style="font-size: 0.85rem;">Komentar untuk mentor:</span>
                            <strong style="color: #60a5fa; font-size: 1.05rem; display: block;"><?= htmlspecialchars($c['mentor_name']); ?></strong>
                            <span class="text-muted" style="font-size: 0.85rem;">
                                @<?= htmlspecialchars($c['mentor_username']); ?> &nbsp;·&nbsp;
                                <span class="badge badge-pending" style="font-size: 0.75rem;"><?= htmlspecialchars($c['skill_name']); ?></span>
                            </span>
                        </div>
                        <span style="font-size: 0.85rem; color: var(--text-muted);"><?= date('d M Y, H:i', strtotime($c['created_at'])); ?></span>
                    </div>
                    <p style="margin: 0; font-size: 1rem; line-height: 1.65;"><?= nl2br(htmlspecialchars($c['comment'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>

<script>
// Ketika mentor dipilih, otomatis set skill_id sesuai keahlian mentor tersebut
function updateSkillFromMentor(select) {
    const skillId = select.options[select.selectedIndex].getAttribute('data-skill-id');
    const skillSelect = document.getElementById('skillSelectAssign');
    if (skillId) {
        skillSelect.value = skillId;
    }
}
</script>
