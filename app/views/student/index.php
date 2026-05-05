<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Dashboard Siswa</h1>
        <p class="text-muted">Selamat datang, <?= htmlspecialchars($data['profile']['full_name']); ?>!</p>
    </div>

    <?php Flasher::flash(); ?>

    <div style="display: grid; grid-template-columns: minmax(0, 1fr); gap: 2rem;">
        
        <!-- Action Cards -->
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <?php if(empty($data['profile']['interest'])): ?>
                <div class="glass-card" style="flex: 1; min-width: min(100%, 320px); text-align: center; background: rgba(79, 70, 229, 0.1); border-color: var(--primary-color);">
                    <h3 style="margin-bottom: 1rem;">Mulai Perjalanan Belajar</h3>
                    <p class="text-muted" style="margin-bottom: 1.5rem;">Ikuti kuesioner singkat untuk rekomendasi keterampilan yang cocok.</p>
                    <a href="<?= BASEURL; ?>/student/questionnaire" class="btn-primary" style="display: inline-block;">Ikuti Kuesioner</a>
                </div>
            <?php else: ?>
                <div class="glass-card" style="flex: 1; min-width: min(100%, 320px);">
                    <h3 style="margin-bottom: 1rem;">Cari Mentor Baru</h3>
                    <p class="text-muted" style="margin-bottom: 1.5rem;">Temukan pakar yang tepat untuk membimbing keterampilanmu.</p>
                    <a href="<?= BASEURL; ?>/student/select_skill" class="btn-primary" style="display: inline-block;">Mulai Pencarian (Gacha)</a>
                </div>
            <?php endif; ?>

            <!-- Notes Link Card -->
            <div class="glass-card" style="flex: 1; min-width: min(100%, 320px); background: rgba(59, 130, 246, 0.08); border-color: #3b82f6; display: flex; flex-direction: column;">
                <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                    <div style="width: 2.5rem; height: 2.5rem; background: rgba(59, 130, 246, 0.2); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: #3b82f6; font-size: 1.1rem;">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    <h3 style="font-size: 1.1rem; margin: 0;">Catatan Jurusan</h3>
                </div>
                <p class="text-muted" style="margin-bottom: 1.5rem; flex: 1;">Kelola catatan belajar Anda berdasarkan jurusan. Simpan hingga 5 catatan penting per jurusan.</p>
                <a href="<?= BASEURL; ?>/student/skill_exchange" class="btn-primary" style="display: inline-block; text-align: center; background: #3b82f6; border-color: #3b82f6;">Kelola Catatan</a>
            </div>
        </div>

        <!-- History/Upcoming Sessions -->
        <div class="glass-card" style="min-width: 0; max-width: 100%;">
            <h2 class="card-title" style="text-align: left; font-size: 1.5rem; margin-bottom: 1rem;">Jadwal & Riwayat Bimbingan</h2>
            
            <?php if(empty($data['sessions'])): ?>
                <p class="text-muted text-center" style="padding: 2rem 0;">Belum ada riwayat bimbingan. Cari mentor terlebih dahulu.</p>
            <?php else: ?>
                <div class="table-container" style="margin-top: 0;">
                    <table>
                        <thead>
                            <tr>
                                <th>Tanggal Sesi</th>
                                <th>Mentor</th>
                                <th>Keterampilan</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Meeting</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['sessions'] as $session): ?>
                            <tr>
                                <td><?= date('d M Y, H:i', strtotime($session['session_date'])); ?></td>
                                <td style="font-weight: 500;"><?= htmlspecialchars($session['mentor_name']); ?></td>
                                <td><?= htmlspecialchars($session['skill_name']); ?></td>
                                <td><?= htmlspecialchars($session['notes']); ?></td>
                                <td>
                                    <?php if($session['status'] == 'pending'): ?>
                                        <span class="badge badge-pending">Menunggu Konfirmasi</span>
                                    <?php elseif($session['status'] == 'confirmed'): ?>
                                        <span class="badge badge-success">Dikonfirmasi</span>
                                    <?php elseif($session['status'] == 'rejected'): ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php else: ?>
                                        <span class="badge" style="background:#6b7280;">Selesai</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($session['status'] == 'confirmed' && !empty($session['meeting_link'])): ?>
                                        <a href="<?= htmlspecialchars($session['meeting_link']); ?>" target="_blank" class="text-link"><i class="fa-solid fa-video"></i> Link Zoom</a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($session['status'] == 'confirmed' || $session['status'] == 'completed'): ?>
                                        <a href="<?= BASEURL; ?>/student/chat/<?= $session['id']; ?>" class="btn-small btn-secondary"><i class="fa-regular fa-comment-dots"></i> Chat</a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
