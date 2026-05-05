<div class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
    <div class="glass-card" style="max-width: 1000px; width: 100%; margin: 0 auto; padding: 3rem;">
        
        <!-- Header Profile -->
        <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1.5rem;">
            <div style="font-size: 4.5rem; color: var(--secondary-color);">
                <i class="fa-solid fa-user-astronaut"></i>
            </div>
            <div>
                <h2 style="font-size: 2.2rem; margin: 0;"><?= htmlspecialchars($data['mentor']['full_name']); ?></h2>
                <p class="text-muted" style="margin: 0; font-size: 1.2rem;">@<?= htmlspecialchars($data['mentor']['username']); ?></p>
            </div>
        </div>

        <h3 style="margin-bottom: 2rem; font-size: 1.7rem;"><i class="fa-regular fa-comments"></i> Ulasan Siswa</h3>
        <?php Flasher::flash(); ?>

        <!-- Comments List -->
        <div style="margin-bottom: 3rem; max-height: 350px; overflow-y: auto; padding-right: 1.5rem;">
            <?php if(empty($data['comments'])): ?>
                <div style="text-align: center; padding: 4rem 1rem; color: var(--text-muted); background: rgba(0,0,0,0.1); border-radius: 1.5rem;">
                    <i class="fa-solid fa-comment-slash" style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.5;"></i>
                    <p style="font-size: 1.2rem;">Belum ada komentar atau ulasan untuk mentor ini.</p>
                </div>
            <?php else: ?>
                <?php foreach($data['comments'] as $c): ?>
                    <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); padding: 1.75rem; border-radius: 1.25rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <div>
                                <strong style="color: #60a5fa; font-size: 1.2rem;"><?= htmlspecialchars($c['full_name']); ?></strong>
                                <br><span style="font-size: 0.85rem; color: var(--text-muted);"><?= date('d M Y, H:i', strtotime($c['created_at'])); ?></span>
                            </div>
                            
                            <?php if ($c['student_user_id'] == $_SESSION['user']['id']): ?>
                                <div style="display: flex; gap: 1rem; align-items: center;">
                                    <?php if(isset($_GET['edit_comment_id']) && $_GET['edit_comment_id'] == $c['id']): ?>
                                        <a href="<?= BASEURL; ?>/student/mentor_comments/<?= $data['mentor']['user_id']; ?>/<?= $data['skill_id']; ?>" class="btn-small" style="background: var(--secondary-color); border: none; padding: 0.4rem 0.8rem; border-radius: 0.5rem; color: white; cursor: pointer; font-size: 0.85rem; text-decoration: none;"><i class="fa-solid fa-xmark" style="margin-right: 0.4rem;"></i> Batal Edit</a>
                                    <?php else: ?>
                                        <a href="<?= BASEURL; ?>/student/mentor_comments/<?= $data['mentor']['user_id']; ?>/<?= $data['skill_id']; ?>?edit_comment_id=<?= $c['id']; ?>" class="btn-small" style="background: var(--secondary-color); border: none; padding: 0.4rem 0.8rem; border-radius: 0.5rem; color: white; cursor: pointer; font-size: 0.85rem; text-decoration: none;"><i class="fa-solid fa-pen" style="margin-right: 0.4rem;"></i> Edit</a>
                                    <?php endif; ?>
                                    <a href="<?= BASEURL; ?>/student/delete_mentor_comment/<?= $c['id']; ?>/<?= $data['mentor']['user_id']; ?>/<?= $data['skill_id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');" class="btn-small btn-danger" style="padding: 0.4rem 0.8rem; border-radius: 0.5rem; font-size: 0.85rem; text-decoration: none;"><i class="fa-solid fa-trash" style="margin-right: 0.4rem;"></i> Hapus</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (isset($_GET['edit_comment_id']) && $_GET['edit_comment_id'] == $c['id'] && $c['student_user_id'] == $_SESSION['user']['id']): ?>
                            <div style="margin-top: 1rem;">
                                <form action="<?= BASEURL; ?>/student/update_mentor_comment" method="post">
                                    <input type="hidden" name="comment_id" value="<?= $c['id']; ?>">
                                    <input type="hidden" name="mentor_id" value="<?= htmlspecialchars($data['mentor']['user_id']); ?>">
                                    <input type="hidden" name="skill_id" value="<?= htmlspecialchars($data['skill_id']); ?>">
                                    <textarea name="comment" rows="3" style="width: 100%; padding: 1rem; border-radius: 0.75rem; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.2); color: white; font-family: inherit; font-size: 1rem; outline: none; resize: vertical;" required><?= htmlspecialchars($c['comment']); ?></textarea>
                                    <div style="text-align: right; margin-top: 0.5rem; display: flex; justify-content: flex-end; gap: 0.5rem;">
                                        <a href="<?= BASEURL; ?>/student/mentor_comments/<?= $data['mentor']['user_id']; ?>/<?= $data['skill_id']; ?>" class="btn-secondary" style="padding: 0.5rem 1rem; border-radius: 1rem; font-size: 0.9rem; cursor: pointer; text-decoration: none;">Batal</a>
                                        <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; border-radius: 1rem; font-size: 0.9rem; cursor: pointer; border: none;">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        <?php else: ?>
                            <div>
                                <p style="margin: 0; font-size: 1.1rem; line-height: 1.6;"><?= nl2br(htmlspecialchars($c['comment'])); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Form Add Comment -->
        <div style="background: rgba(0,0,0,0.2); padding: 2.5rem; border-radius: 1.5rem; margin-bottom: 3rem;">
            <h4 style="margin-bottom: 1.5rem; font-size: 1.4rem;">Tinggalkan Komentar</h4>
            <form action="<?= BASEURL; ?>/student/post_mentor_comment" method="post">
                <input type="hidden" name="mentor_id" value="<?= htmlspecialchars($data['mentor']['user_id']); ?>">
                <input type="hidden" name="skill_id" value="<?= htmlspecialchars($data['skill_id']); ?>">
                <textarea name="comment" rows="4" placeholder="Tuliskan ulasan atau pengalaman Anda tentang mentor ini..." style="width: 100%; padding: 1.25rem; border-radius: 1rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: inherit; font-family: inherit; font-size: 1.15rem; margin-bottom: 1.5rem; outline: none; resize: vertical;" required></textarea>
                <div style="text-align: right;">
                    <button type="submit" class="btn-primary" style="padding: 1rem 2.5rem; font-size: 1.2rem; border-radius: 2rem;">
                        <i class="fa-solid fa-paper-plane"></i> Kirim
                    </button>
                </div>
            </form>
        </div>

        <!-- Back Button Form -->
        <form action="<?= BASEURL; ?>/student/gacha" method="post" style="text-align: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2.5rem;">
            <input type="hidden" name="skill_id" value="<?= htmlspecialchars($data['skill_id']); ?>">
            <input type="hidden" name="mentor_id" value="<?= htmlspecialchars($data['mentor']['user_id']); ?>">
            <button type="submit" class="btn-secondary" style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 1rem 3rem; font-size: 1.2rem; border-radius: 2.5rem; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: inherit; cursor: pointer;">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Mentor
            </button>
        </form>

    </div>
</div>
