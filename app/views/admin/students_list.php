<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">

    <div style="margin-bottom: 2rem;">
        <a href="<?= BASEURL; ?>/admin" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 2rem; text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem;"><i class="fa-solid fa-users" style="color: var(--primary-color); margin-right: 0.5rem;"></i> Daftar Akun Siswa</h1>
            <p class="text-muted">Kelola semua akun siswa, lihat aktivitas bimbingan, dan atur profil mereka di sini.</p>
        </div>
    </div>

    <?php Flasher::flash(); ?>

    <div class="glass-card" style="max-width: 100%;">
        <!-- Search Bar -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: 1.5rem;">
            <div style="position: relative; width: 100%; max-width: 350px;">
                <i class="fa-solid fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted);"></i>
                <input type="text" id="searchStudent" placeholder="Cari berdasarkan nama lengkap..." class="form-control" style="padding-left: 2.8rem; border-radius: 2rem; width: 100%;">
            </div>
        </div>


        <?php if(empty($data['students'])): ?>
            <div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                <i class="fa-solid fa-users-slash" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; display: block;"></i>
                <p style="margin: 0; font-size: 1.1rem;">Belum ada data siswa yang terdaftar saat ini.</p>
            </div>
        <?php else: ?>
            <div class="table-container" style="margin-top: 0;">
                <table id="studentTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Minat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['students'] as $i => $student): ?>
                        <tr>
                            <td><?= $i + 1; ?></td>
                            <td style="font-weight: 500;"><?= htmlspecialchars($student['full_name']); ?></td>
                            <td><?= htmlspecialchars($student['username']); ?></td>
                            <td><?= htmlspecialchars($student['email'] ?? '-'); ?></td>
                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= htmlspecialchars($student['interest'] ?? '-'); ?>
                            </td>
                            <td style="white-space: nowrap;">
                                <div style="display:flex; gap:0.75rem; flex-wrap: nowrap; align-items: center;">
                                    <a href="<?= BASEURL; ?>/admin/student_profile/<?= $student['user_id']; ?>" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 0.5rem; text-decoration: none; white-space: nowrap;">
                                        <i class="fa-solid fa-user-pen" style="margin-right: 0.4rem;"></i> Lihat Profil
                                    </a>
                                    <a href="<?= BASEURL; ?>/admin/delete_student/<?= $student['user_id']; ?>" class="btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: 0.5rem; text-decoration: none; white-space: nowrap;" onclick="return confirm('Hapus akun siswa <?= htmlspecialchars(addslashes($student['full_name'])); ?>? Semua data siswa akan ikut terhapus.');">
                                        <i class="fa-solid fa-trash" style="margin-right: 0.4rem;"></i> Hapus Akun
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.getElementById('searchStudent').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#studentTable tbody tr');

    rows.forEach(row => {
        let nameCell = row.querySelector('td:nth-child(2)'); // Kolom Nama Lengkap ada di urutan kedua
        if (nameCell) {
            let nameText = nameCell.textContent || nameCell.innerText;
            if (nameText.toLowerCase().indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
</script>
