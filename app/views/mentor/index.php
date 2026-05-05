<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Dashboard Mentor</h1>
        <p class="text-muted">Selamat datang, <?= htmlspecialchars($data['profile']['full_name']); ?>!</p>
    </div>

    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); padding: 1rem 1.5rem; border-radius: 1rem; margin-bottom: 2rem; display: inline-block;">
        <p style="margin: 0; font-size: 0.9rem;">
            Bidang Keahlian: <strong style="color: var(--secondary-color);"><?= htmlspecialchars($data['profile']['skill_name']); ?></strong> 
            | Status: <span class="badge badge-success">Approved</span>
        </p>
    </div>

    <?php Flasher::flash(); ?>

    <div class="glass-card" style="background: transparent; border: none; padding: 0; box-shadow: none;">
        <h2 class="card-title" style="text-align: left; font-size: 1.5rem; margin-bottom: 1.5rem;">Permintaan Sesi Bimbingan</h2>
        
        <?php if(empty($data['requests'])): ?>
            <div class="glass-card" style="text-align: center; padding: 3rem;">
                <p class="text-muted">Belum ada permintaan bimbingan saat ini.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                            <?php foreach($data['requests'] as $req): ?>
                            <div class="glass-card" style="padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                        <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: var(--text-main);"><?= htmlspecialchars($req['student_name']); ?></h3>
                                        <?php if($req['status'] == 'pending'): ?>
                                            <span class="badge badge-pending">Menunggu</span>
                                        <?php elseif($req['status'] == 'confirmed'): ?>
                                            <span class="badge badge-success">Dikonfirmasi</span>
                                        <?php elseif($req['status'] == 'rejected'): ?>
                                            <span class="badge badge-danger">Ditolak</span>
                                        <?php else: ?>
                                            <span class="badge" style="background:#6b7280;">Selesai</span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-muted" style="margin-bottom: 0.5rem;"><i class="fa-regular fa-calendar" style="margin-right: 0.5rem;"></i> <?= date('d M Y, H:i', strtotime($req['session_date'])); ?></p>
                                    <p class="text-sm text-muted" style="margin-bottom: 1rem;"><i class="fa-regular fa-user" style="margin-right: 0.5rem;"></i> @<?= htmlspecialchars($req['student_username']); ?></p>
                                    
                                    <div style="background: rgba(0,0,0,0.2); padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                                        <p class="text-sm" style="margin: 0; word-wrap: break-word;"><strong>Topik:</strong> <?= htmlspecialchars($req['notes']); ?></p>
                                    </div>
                                    
                                    <?php if($req['status'] == 'confirmed' && !empty($req['meeting_link'])): ?>
                                        <div style="margin-bottom: 1.5rem;">
                                            <p class="text-sm" style="margin: 0;"><strong>Link Meeting:</strong> <br><a href="<?= htmlspecialchars($req['meeting_link']); ?>" target="_blank" class="text-link" style="word-wrap: break-word;"><?= htmlspecialchars($req['meeting_link']); ?></a></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div style="display:flex; gap:0.5rem; justify-content: flex-end; align-items: center; border-top: 1px solid var(--glass-border); padding-top: 1rem;">
                                    <?php if($req['status'] == 'pending'): ?>
                                        <a href="<?= BASEURL; ?>/mentor/reject_session/<?= $req['id']; ?>" class="btn-small btn-danger" onclick="return confirm('Tolak jadwal ini?');">Tolak</a>
                                        
                                        <!-- Form Confirm with Zoom Link -->
                                        <form action="<?= BASEURL; ?>/mentor/confirm_session_with_link" method="post" style="display:flex; gap:0.5rem; flex:1;">
                                            <input type="hidden" name="id" value="<?= $req['id']; ?>">
                                            <input type="url" name="meeting_link" class="form-control" placeholder="Link Zoom/Meet (Opsional)" style="padding: 0.3rem 0.5rem; font-size: 0.8rem; height: auto;">
                                            <button type="submit" class="btn-small btn-success" style="white-space: nowrap;">Terima</button>
                                        </form>

                                    <?php elseif($req['status'] == 'confirmed'): ?>
                                        <a href="<?= BASEURL; ?>/mentor/chat/<?= $req['id']; ?>" class="btn-small" style="background: var(--secondary-color); color: white;"><i class="fa-regular fa-comment-dots"></i> Pesan</a>
                                        <a href="<?= BASEURL; ?>/mentor/complete_session/<?= $req['id']; ?>" class="btn-small" style="background: var(--primary-color); color: white;" onclick="return confirm('Tandai sesi ini sudah selesai?');"><i class="fa-solid fa-check"></i> Selesai</a>
                                    <?php elseif($req['status'] == 'completed'): ?>
                                        <a href="<?= BASEURL; ?>/mentor/chat/<?= $req['id']; ?>" class="btn-small btn-secondary"><i class="fa-regular fa-comment-dots"></i> Lihat Obrolan</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
        <?php endif; ?>
    </div>

    <!-- Student Comments Section -->
    <div class="glass-card" style="background: transparent; border: none; padding: 0; box-shadow: none; margin-top: 3rem;">
        <h2 class="card-title" style="text-align: left; font-size: 1.5rem; margin-bottom: 1.5rem;"><i class="fa-regular fa-comments"></i> Ulasan Siswa</h2>
        
        <?php if(empty($data['comments'])): ?>
            <div class="glass-card" style="text-align: center; padding: 3rem;">
                <p class="text-muted">Belum ada komentar dari siswa.</p>
            </div>
        <?php else: ?>
            <?php 
            $total_comments = count($data['comments']);
            $display_comments = array_slice($data['comments'], 0, 3);
            ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
                <?php foreach($display_comments as $comment): ?>
                    <div class="glass-card" style="padding: 1.5rem; display: flex; flex-direction: column;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <strong style="color: #60a5fa; font-size: 1.1rem;"><?= htmlspecialchars($comment['full_name']); ?></strong>
                            <span style="font-size: 0.85rem; color: var(--text-muted);"><?= date('d M Y, H:i', strtotime($comment['created_at'])); ?></span>
                        </div>
                        <p style="margin: 0; font-size: 1rem; line-height: 1.5; flex-grow: 1;"><?= nl2br(htmlspecialchars($comment['comment'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if($total_comments > 3): ?>
                <div style="text-align: center;">
                    <a href="<?= BASEURL; ?>/mentor/comments" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 2rem; border-radius: 2rem; text-decoration: none;">
                        <i class="fa-solid fa-list"></i> Lihat Semua Ulasan (<?= $total_comments; ?>)
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
