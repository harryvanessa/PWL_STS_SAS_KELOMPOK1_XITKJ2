<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">

    <div style="margin-bottom: 1.5rem;">
        <a href="<?= BASEURL; ?>/admin" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; border-radius: 2rem; text-decoration: none;">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="glass-card" style="max-width: 1000px; width: 100%; margin: 0 auto; padding: 3rem;">

        <?php Flasher::flash(); ?>

        <!-- Header Profile Mentor -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1.5rem; gap: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div style="font-size: 4.5rem; color: var(--secondary-color);">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div>
                    <h2 style="font-size: 2.2rem; margin: 0;"><?= htmlspecialchars($data['mentor']['full_name']); ?></h2>
                    <p class="text-muted" style="margin: 0 0 0.5rem 0; font-size: 1.2rem;">@<?= htmlspecialchars($data['mentor']['username']); ?></p>
                    <span class="badge badge-success">Keahlian: <?= htmlspecialchars($data['mentor']['skill_name']); ?></span>
                </div>
            </div>
            <div>
                <a href="<?= BASEURL; ?>/admin/dismiss_mentor/<?= $data['mentor']['id']; ?>"
                   class="btn-danger"
                   style="padding: 0.75rem 1.5rem; border-radius: 2rem; text-decoration: none; display: inline-block;"
                   onclick="return confirm('Berhentikan mentor <?= htmlspecialchars(addslashes($data['mentor']['full_name'])); ?>? Mentor tidak akan aktif lagi.');">
                    <i class="fa-solid fa-user-xmark"></i> Berhentikan Mentor
                </a>
            </div>
        </div>

        <!-- Pengalaman Mentor -->
        <div style="margin-bottom: 2.5rem; background: rgba(0,0,0,0.15); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--glass-border);">
            <h4 style="margin-bottom: 0.75rem; font-size: 1.1rem; color: #60a5fa;">Pengalaman Mentor:</h4>
            <p style="margin: 0; font-size: 1rem; line-height: 1.7;"><?= nl2br(htmlspecialchars($data['mentor']['experience'])); ?></p>
        </div>

        <!-- Ganti Jurusan / Keahlian -->
        <div style="margin-bottom: 2.5rem; background: rgba(0,0,0,0.15); padding: 1.5rem; border-radius: 1rem; border: 1px solid var(--glass-border);">
            <h4 style="margin-bottom: 1rem; font-size: 1.1rem;">Ganti Jurusan / Keahlian Mentor</h4>
            <form action="<?= BASEURL; ?>/admin/update_mentor_skill" method="post" style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
                <input type="hidden" name="id" value="<?= $data['mentor']['id']; ?>">
                <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                    <label class="form-label">Pilih Keahlian Baru:</label>
                    <select name="skill_id" class="form-control" required>
                        <?php foreach($data['skills'] as $skill): ?>
                            <option value="<?= $skill['id']; ?>" <?= ($skill['id'] == $data['mentor']['skill_id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($skill['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn-primary" style="padding: 0.75rem 1.5rem;">Simpan Perubahan</button>
            </form>
        </div>

        <!-- Manajemen Komentar -->
        <h3 style="margin-bottom: 0.5rem; font-size: 1.7rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem;">
            <i class="fa-regular fa-comments"></i> Komentar Siswa
        </h3>
        <p class="text-muted" style="margin-bottom: 2rem;">Admin dapat mengedit dan menghapus komentar siapapun, serta menambahkan komentar evaluasi.</p>

        <!-- Form Tambah Komentar Admin -->
        <div style="background: rgba(0,0,0,0.2); padding: 2rem; border-radius: 1.5rem; margin-bottom: 2.5rem; border: 1px solid rgba(255,255,255,0.08);">
            <h4 style="margin-bottom: 1rem; font-size: 1.1rem;"><i class="fa-solid fa-pen-to-square"></i> Tambahkan Komentar sebagai Admin</h4>
            <form action="<?= BASEURL; ?>/admin/add_mentor_comment" method="post">
                <input type="hidden" name="mentor_profile_id" value="<?= $data['mentor']['id']; ?>">
                <input type="hidden" name="mentor_user_id" value="<?= $data['mentor']['user_id']; ?>">
                <textarea name="comment" rows="3" placeholder="Ketik evaluasi atau catatan untuk mentor ini..."
                    style="width: 100%; padding: 1rem; border-radius: 0.75rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: inherit; font-family: inherit; font-size: 1rem; margin-bottom: 1rem; outline: none; resize: vertical; box-sizing: border-box;" required></textarea>
                <div style="text-align: right;">
                    <button type="submit" class="btn-primary" style="padding: 0.75rem 2rem; border-radius: 2rem;">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Komentar Admin
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Komentar -->
        <div style="margin-bottom: 2rem;">
            <?php if(empty($data['comments'])): ?>
                <div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted); background: rgba(0,0,0,0.1); border-radius: 1.5rem;">
                    <i class="fa-solid fa-comment-slash" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                    <p style="font-size: 1.1rem;">Belum ada komentar untuk mentor ini.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['comments'] as $c): ?>
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); padding: 1.75rem; border-radius: 1.25rem; margin-bottom: 1.5rem; position: relative;">

                        <?php if ($c['role'] === 'admin'): ?>
                            <span style="position: absolute; top: -10px; right: 16px; background: #3b82f6; color: white; padding: 0.15rem 0.75rem; border-radius: 999px; font-size: 0.78rem; font-weight: 600;">Admin</span>
                        <?php endif; ?>

                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
                            <div>
                                <strong style="color: #60a5fa; font-size: 1.1rem;"><?= htmlspecialchars($c['full_name']); ?></strong>
                                <span class="text-muted" style="font-size: 0.9rem; margin-left: 0.4rem;">(@<?= htmlspecialchars($c['username']); ?>)</span>
                                <br>
                                <span style="font-size: 0.85rem; color: var(--text-muted);"><?= date('d M Y, H:i', strtotime($c['created_at'])); ?></span>
                            </div>

                            <!-- Tombol Edit / Hapus -->
                            <div style="display: flex; gap: 0.5rem; align-items: center;">
                                <?php if(isset($_GET['edit_id']) && $_GET['edit_id'] == $c['id']): ?>
                                    <a href="<?= BASEURL; ?>/admin/mentor_profile/<?= $data['mentor']['id']; ?>"
                                       class="btn-small" style="background: var(--secondary-color); border: none; padding: 0.4rem 0.8rem; border-radius: 0.5rem; color: white; font-size: 0.85rem; text-decoration: none;">
                                        <i class="fa-solid fa-xmark" style="margin-right: 0.3rem;"></i> Batal Edit
                                    </a>
                                <?php else: ?>
                                    <a href="<?= BASEURL; ?>/admin/mentor_profile/<?= $data['mentor']['id']; ?>?edit_id=<?= $c['id']; ?>"
                                       class="btn-small" style="background: var(--secondary-color); border: none; padding: 0.4rem 0.8rem; border-radius: 0.5rem; color: white; font-size: 0.85rem; text-decoration: none;">
                                        <i class="fa-solid fa-pen" style="margin-right: 0.3rem;"></i> Edit
                                    </a>
                                <?php endif; ?>
                                <a href="<?= BASEURL; ?>/admin/delete_mentor_comment/<?= $c['id']; ?>/<?= $data['mentor']['id']; ?>"
                                   onclick="return confirm('Hapus komentar ini?');"
                                   class="btn-small btn-danger" style="padding: 0.4rem 0.8rem; border-radius: 0.5rem; font-size: 0.85rem; text-decoration: none;">
                                    <i class="fa-solid fa-trash" style="margin-right: 0.3rem;"></i> Hapus
                                </a>
                            </div>
                        </div>

                        <!-- Form Edit Inline -->
                        <?php if (isset($_GET['edit_id']) && $_GET['edit_id'] == $c['id']): ?>
                            <div style="margin-top: 1rem; border-top: 1px dashed rgba(255,255,255,0.15); padding-top: 1rem;">
                                <form action="<?= BASEURL; ?>/admin/edit_mentor_comment" method="post">
                                    <input type="hidden" name="comment_id" value="<?= $c['id']; ?>">
                                    <input type="hidden" name="mentor_profile_id" value="<?= $data['mentor']['id']; ?>">
                                    <textarea name="comment" rows="3"
                                        style="width: 100%; padding: 1rem; border-radius: 0.75rem; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.2); color: white; font-family: inherit; font-size: 1rem; outline: none; resize: vertical; box-sizing: border-box;" required><?= htmlspecialchars($c['comment']); ?></textarea>
                                    <div style="text-align: right; margin-top: 0.5rem; display: flex; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="<?= BASEURL; ?>/admin/mentor_profile/<?= $data['mentor']['id']; ?>"
                                           class="btn-secondary" style="padding: 0.5rem 1rem; border-radius: 1rem; font-size: 0.9rem; text-decoration: none;">Batal</a>
                                        <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; border-radius: 1rem; font-size: 0.9rem; border: none; cursor: pointer;">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        <?php else: ?>
                            <p style="margin: 0; font-size: 1.05rem; line-height: 1.65;"><?= nl2br(htmlspecialchars($c['comment'])); ?></p>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>
