<div class="container">
    <div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Dashboard Admin</h1>
            <p class="text-muted">Kelola pendaftaran mentor dan daftar keterampilan.</p>
        </div>
    </div>

    <?php Flasher::flash(); ?>

    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">
        
        <!-- Section: Pending Mentors -->
        <div class="glass-card" style="max-width: 100%;">
            <h2 class="card-title" style="text-align: left; font-size: 1.5rem; margin-bottom: 1rem;">Menunggu Persetujuan Mentor</h2>
            
            <?php if(empty($data['mentors'])): ?>
                <p class="text-muted">Tidak ada mentor yang menunggu persetujuan saat ini.</p>
            <?php else: ?>
                <div class="table-container" style="margin-top: 0;">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Keahlian</th>
                                <th>Pengalaman</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['mentors'] as $mentor): ?>
                            <tr>
                                <td><?= htmlspecialchars($mentor['full_name']); ?></td>
                                <td><?= htmlspecialchars($mentor['username']); ?></td>
                                <td><span class="badge badge-pending"><?= htmlspecialchars($mentor['skill_name']); ?></span></td>
                                <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?= htmlspecialchars($mentor['experience']); ?>
                                </td>
                                <td>
                                    <div style="display:flex; gap:0.5rem; flex-wrap: wrap;">
                                        <a href="<?= BASEURL; ?>/admin/approve_mentor/<?= $mentor['id']; ?>" class="btn-small btn-success" onclick="return confirm('Setujui mentor ini?');">Approve</a>
                                        
                                        <!-- Form Reject with Feedback -->
                                        <form action="<?= BASEURL; ?>/admin/reject_mentor" method="post" style="display:inline;" onsubmit="return confirm('Tolak mentor ini?');">
                                            <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                                            <input type="hidden" name="id" value="<?= $mentor['id']; ?>">
                                            <div style="display:flex; gap: 0.5rem;">
                                                <input type="text" name="feedback" placeholder="Alasan penolakan..." required class="form-control" style="padding: 0.3rem 0.5rem; font-size: 0.8rem; height: auto; width: 150px;">
                                                <button type="submit" class="btn-small btn-danger">Reject</button>
                                            </div>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <!-- Section: Skills Management -->
        <div class="glass-card" style="max-width: 100%;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h2 class="card-title" style="text-align: left; font-size: 1.5rem; margin-bottom: 0;">Kelola Keterampilan (Skills)</h2>
                <button onclick="document.getElementById('addSkillForm').style.display='block'" class="btn-small btn-success" style="padding: 0.6rem 1rem;">+ Tambah Skill</button>
            </div>

            <!-- Form Tambah Skill (Hidden by default) -->
            <div id="addSkillForm" style="display:none; background: rgba(0,0,0,0.2); padding: 1.5rem; border-radius: 1rem; margin-bottom: 1.5rem; border: 1px solid var(--glass-border);">
                <form action="<?= BASEURL; ?>/admin/add_skill" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                    <div style="display:flex; gap:1rem; align-items:flex-end;">
                        <div class="form-group" style="flex:1; margin-bottom:0;">
                            <label for="name" class="form-label">Nama Keterampilan</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Web Development" required>
                        </div>
                        <div class="form-group" style="flex:2; margin-bottom:0;">
                            <label for="description" class="form-label">Deskripsi</label>
                            <input type="text" name="description" class="form-control" placeholder="Penjelasan singkat tentang skill ini" required>
                        </div>
                        <button type="submit" class="btn-primary" style="padding: 0.75rem 1.5rem;">Simpan</button>
                        <button type="button" onclick="document.getElementById('addSkillForm').style.display='none'" class="btn-danger" style="padding: 0.75rem 1.5rem; border-radius: 9999px;">Batal</button>
                    </div>
                </form>
            </div>

            <div class="table-container" style="margin-top: 0;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Keterampilan</th>
                            <th>Deskripsi</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['skills'] as $skill): ?>
                        <tr>
                            <td><?= $skill['id']; ?></td>
                            <td style="font-weight: 500;"><?= htmlspecialchars($skill['name']); ?></td>
                            <td><?= htmlspecialchars($skill['description']); ?></td>
                            <td>
                                <a href="<?= BASEURL; ?>/admin/delete_skill/<?= $skill['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Hapus keterampilan ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
