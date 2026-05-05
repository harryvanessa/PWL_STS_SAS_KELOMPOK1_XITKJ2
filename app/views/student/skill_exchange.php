<div class="container" style="padding-bottom: 4rem;">
    <!-- Header -->
    <div
        style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.5rem;">Catatan Jurusan</h1>
            <p style="color: var(--text-muted);">Kelola catatan belajar Anda berdasarkan jurusan. Maksimal 5 catatan per jurusan.</p>
        </div>
<<<<<<< HEAD
        <button onclick="document.getElementById('modal-add-skill').style.display='flex'" class="btn-primary"
            style="display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-plus"></i> Tawarkan Keterampilanku
        </button>
    </div>

    <?php Flasher::flash(); ?>

    <!-- ═══ TABS ════════════════════════════════════════ -->
    <div
        style="display: flex; gap: 0.5rem; margin-bottom: 2rem; border-bottom: 1px solid var(--border-color); flex-wrap: wrap;">
        <button class="tab-btn tab-active" onclick="switchTab('tab-browse')">
            <i class="fa-solid fa-globe"></i> Jelajahi Keterampilan
        </button>
        <button class="tab-btn" onclick="switchTab('tab-mine')">
            <i class="fa-solid fa-user"></i> Keterampilanku
            <?php if (!empty($data['my_skills'])): ?>
                <span
                    style="background: var(--primary-color); color: white; border-radius: 99px; padding: 1px 8px; font-size: 0.75rem;"><?= count($data['my_skills']); ?></span>
            <?php endif; ?>
        </button>
        <button class="tab-btn" onclick="switchTab('tab-requests')">
            <i class="fa-solid fa-bell"></i> Permintaan Masuk
            <?php $pending = array_filter($data['incoming'], fn($r) => $r['status'] === 'pending'); ?>
            <?php if (!empty($pending)): ?>
                <span
                    style="background: #ef4444; color: white; border-radius: 99px; padding: 1px 8px; font-size: 0.75rem;"><?= count($pending); ?></span>
            <?php endif; ?>
        </button>
        <button class="tab-btn" onclick="switchTab('tab-sent')">
            <i class="fa-solid fa-paper-plane"></i> Permintaan Terkirim
        </button>
    </div>

    <!-- ═══ TAB: BROWSE ══════════════════════════════════ -->
    <div id="tab-browse" class="tab-content">
        <?php if (empty($data['listings'])): ?>
            <div class="glass-card" style="text-align: center; padding: 3rem;">
                <i class="fa-solid fa-handshake"
                    style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3 style="margin-bottom: 0.5rem;">Belum Ada Yang Menawarkan</h3>
                <p style="color: var(--text-muted);">Jadilah yang pertama menawarkan keterampilanmu!</p>
            </div>
        <?php else: ?>
            <!-- Filter -->
            <div style="margin-bottom: 1.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
                <span style="color: var(--text-muted); font-size: 0.9rem;">Filter:</span>
                <button class="filter-btn filter-active" onclick="filterSkills('all')">Semua</button>
                <?php foreach ($data['skills'] as $s): ?>
                    <button class="filter-btn" onclick="filterSkills('<?= $s['id']; ?>')" data-skill-id="<?= $s['id']; ?>">
                        <?= htmlspecialchars($s['name']); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div id="skill-grid"
                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem;">
                <?php foreach ($data['listings'] as $listing): ?>
                    <a href="<?= BASEURL; ?>/student/skill_detail/<?= $listing['id']; ?>" class="skill-card"
                        data-skill-id="<?= $listing['skill_id'] ?? ''; ?>" style="text-decoration: none; color: inherit;">
                        <div class="glass-card"
                            style="margin-bottom: 0; height: 100%; transition: transform 0.2s, box-shadow 0.2s; cursor: pointer;">
                            <div
                                style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                <span class="badge badge-primary"
                                    style="font-size: 0.8rem;"><?= htmlspecialchars($listing['skill_name']); ?></span>
                                <?php
                                $levelColors = ['beginner' => '#10b981', 'intermediate' => '#f59e0b', 'advanced' => '#e55f4f'];
                                $levelLabels = ['beginner' => 'Pemula', 'intermediate' => 'Menengah', 'advanced' => 'Mahir'];
                                $lc = $levelColors[$listing['level']] ?? '#64748b';
                                $ll = $levelLabels[$listing['level']] ?? $listing['level'];
                                ?>
                                <span
                                    style="background: <?= $lc; ?>22; color: <?= $lc; ?>; border: 1px solid <?= $lc; ?>44; padding: 2px 10px; border-radius: 99px; font-size: 0.75rem; font-weight: 700;">
                                    <?= $ll; ?>
                                </span>
                            </div>

                            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                                <div
                                    style="width: 2.75rem; height: 2.75rem; border-radius: 50%; background: linear-gradient(135deg, var(--primary-color), #6d28d9); display: flex; align-items: center; justify-content: center; font-weight: 800; color: white; font-size: 1rem; flex-shrink: 0;">
                                    <?= strtoupper(mb_substr($listing['full_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <p style="font-weight: 600; font-size: 0.9rem;">
                                        <?= htmlspecialchars($listing['full_name']); ?></p>
                                    <p style="color: var(--text-muted); font-size: 0.8rem;">
                                        @<?= htmlspecialchars($listing['username']); ?></p>
                                </div>
                            </div>

                            <?php if ($listing['description']): ?>
                                <p
                                    style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= htmlspecialchars($listing['description']); ?>
                                </p>
                            <?php endif; ?>

                            <div
                                style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                                <span style="color: var(--text-muted); font-size: 0.8rem;">
                                    <i class="fa-solid fa-calendar-alt"></i>
                                    <?= date('d M Y', strtotime($listing['created_at'])); ?>
                                </span>
                                <span style="color: var(--primary-color); font-size: 0.85rem; font-weight: 600;">
                                    Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- ═══ TAB: MY SKILLS ══════════════════════════════ -->
    <div id="tab-mine" class="tab-content" style="display: none;">
        <?php if (empty($data['my_skills'])): ?>
            <div class="glass-card" style="text-align: center; padding: 3rem;">
                <i class="fa-solid fa-star-of-life"
                    style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3 style="margin-bottom: 0.5rem;">Belum ada keterampilan</h3>
                <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Daftarkan keterampilan yang kamu miliki untuk
                    dilihat siswa lain.</p>
                <button onclick="document.getElementById('modal-add-skill').style.display='flex'" class="btn-primary">
                    <i class="fa-solid fa-plus"></i> Tambah Keterampilan
                </button>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.25rem;">
                <?php foreach ($data['my_skills'] as $ms): ?>
                    <div class="glass-card" style="margin-bottom: 0; position: relative;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <span class="badge badge-primary"><?= htmlspecialchars($ms['skill_name']); ?></span>
                            <a href="<?= BASEURL; ?>/student/delete_skill/<?= $ms['id']; ?>"
                                onclick="return confirm('Hapus keterampilan ini?')" class="btn-small btn-danger"
                                style="font-size: 0.8rem;">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </div>
                        <?php
                        $lc2 = $levelColors[$ms['level']] ?? '#64748b';
                        $ll2 = $levelLabels[$ms['level']] ?? $ms['level'];
                        ?>
                        <span
                            style="background: <?= $lc2; ?>22; color: <?= $lc2; ?>; border: 1px solid <?= $lc2; ?>44; padding: 2px 10px; border-radius: 99px; font-size: 0.75rem; font-weight: 700; display: inline-block; margin-bottom: 0.75rem;">
                            <?= $ll2; ?>
                        </span>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">
                            <?= htmlspecialchars($ms['description'] ?? '-'); ?></p>
                        <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.75rem;"><i
                                class="fa-solid fa-calendar-alt"></i> <?= date('d M Y', strtotime($ms['created_at'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- ═══ TAB: INCOMING REQUESTS ══════════════════════ -->
    <div id="tab-requests" class="tab-content" style="display: none;">
        <?php if (empty($data['incoming'])): ?>
            <div class="glass-card" style="text-align: center; padding: 3rem;">
                <i class="fa-solid fa-inbox" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3 style="margin-bottom: 0.5rem;">Belum Ada Permintaan</h3>
                <p style="color: var(--text-muted);">Permintaan pertukaran dari siswa lain akan muncul di sini.</p>
            </div>
        <?php else: ?>
            <div class="table-container" style="margin-top: 0;">
                <table>
                    <thead>
                        <tr>
                            <th>Dari</th>
                            <th>Keterampilan Diminta</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['incoming'] as $req): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($req['requester_name']); ?></strong><br>
                                    <span
                                        style="color: var(--text-muted); font-size: 0.8rem;">@<?= htmlspecialchars($req['requester_username']); ?></span>
                                </td>
                                <td>
                                    <?= htmlspecialchars($req['skill_name']); ?><br>
                                    <span
                                        style="color: var(--text-muted); font-size: 0.8rem;"><?= $levelLabels[$req['level']] ?? $req['level']; ?></span>
                                </td>
                                <td style="max-width: 200px; color: var(--text-muted); font-size: 0.9rem;">
                                    <?= htmlspecialchars($req['message'] ?: '-'); ?></td>
                                <td>
                                    <?php if ($req['status'] === 'pending'): ?>
                                        <span class="badge badge-pending">Menunggu</span>
                                    <?php elseif ($req['status'] === 'accepted'): ?>
                                        <span class="badge badge-success">Diterima</span>
                                    <?php else: ?>
                                        <span class="badge"
                                            style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3);">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($req['status'] === 'pending'): ?>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <form action="<?= BASEURL; ?>/student/respond_exchange" method="post">
                                                <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                                                <input type="hidden" name="id" value="<?= $req['id']; ?>">
                                                <input type="hidden" name="action" value="accept">
                                                <button type="submit" class="btn-small btn-success"><i
                                                        class="fa-solid fa-check"></i> Terima</button>
                                            </form>
                                            <form action="<?= BASEURL; ?>/student/respond_exchange" method="post">
                                                <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">
                                                <input type="hidden" name="id" value="<?= $req['id']; ?>">
                                                <input type="hidden" name="action" value="reject">
                                                <button type="submit" class="btn-small btn-danger"><i class="fa-solid fa-xmark"></i>
                                                    Tolak</button>
                                            </form>
                                        </div>
                                    <?php else: ?><span class="text-muted">-</span><?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- ═══ TAB: SENT REQUESTS ══════════════════════════ -->
    <div id="tab-sent" class="tab-content" style="display: none;">
        <?php if (empty($data['outgoing'])): ?>
            <div class="glass-card" style="text-align: center; padding: 3rem;">
                <i class="fa-solid fa-paper-plane"
                    style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                <h3>Belum Ada Permintaan Terkirim</h3>
                <p style="color: var(--text-muted);">Jelajahi keterampilan siswa lain untuk memulai pertukaran.</p>
            </div>
        <?php else: ?>
            <div class="table-container" style="margin-top: 0;">
                <table>
                    <thead>
                        <tr>
                            <th>Kepada</th>
                            <th>Keterampilan Diminta</th>
                            <th>Pesanku</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['outgoing'] as $req): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($req['provider_name']); ?></strong><br>
                                    <span
                                        style="color: var(--text-muted); font-size: 0.8rem;">@<?= htmlspecialchars($req['provider_username']); ?></span>
                                </td>
                                <td><?= htmlspecialchars($req['skill_name']); ?></td>
                                <td style="max-width: 200px; color: var(--text-muted); font-size: 0.9rem;">
                                    <?= htmlspecialchars($req['message'] ?: '-'); ?></td>
                                <td>
                                    <?php if ($req['status'] === 'pending'): ?>
                                        <span class="badge badge-pending">Menunggu</span>
                                    <?php elseif ($req['status'] === 'accepted'): ?>
                                        <span class="badge badge-success">Diterima</span>
                                    <?php else: ?>
                                        <span class="badge"
                                            style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3);">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td style="color: var(--text-muted); font-size: 0.85rem;">
                                    <?= date('d M Y', strtotime($req['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ═══ MODAL: ADD SKILL ═══════════════════════════════════════════════════════ -->
<div id="modal-add-skill"
    style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 5000; align-items: center; justify-content: center; padding: 1rem;">
    <div class="glass-card" style="width: 100%; max-width: 480px; margin: 0; position: relative;">
        <button onclick="document.getElementById('modal-add-skill').style.display='none'"
            style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer; line-height: 1;">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2 class="card-title" style="font-size: 1.5rem; margin-bottom: 0.5rem;">Tawarkan Keterampilanku</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem; font-size: 0.95rem;">Beritahu teman-teman tentang
            keahlian yang kamu punya!</p>

        <form action="<?= BASEURL; ?>/student/add_skill" method="post" class="zenith-form">
            <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">

            <div class="zenith-group">
                <label>Bidang Keterampilan</label>
                <div class="zenith-input-wrapper">
                    <i class="fa-solid fa-lightbulb"></i>
                    <select name="skill_id" required>
                        <option value="" disabled selected>-- Pilih Keterampilan --</option>
                        <?php foreach ($data['skills'] as $s): ?>
                            <option value="<?= $s['id']; ?>"><?= htmlspecialchars($s['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="zenith-group">
                <label>Level Kemampuan</label>
                <div class="zenith-input-wrapper">
                    <i class="fa-solid fa-chart-bar"></i>
                    <select name="level" required>
                        <option value="beginner">Pemula</option>
                        <option value="intermediate">Menengah</option>
                        <option value="advanced">Mahir</option>
                    </select>
                </div>
            </div>

            <div class="zenith-group">
                <label>Deskripsi Singkat</label>
                <div class="zenith-input-wrapper">
                    <textarea name="description" rows="3"
                        placeholder="Ceritakan singkat kemampuanmu di bidang ini..."></textarea>
                </div>
            </div>

            <button type="submit" class="zenith-btn-primary">
                <i class="fa-solid fa-paper-plane"></i> Publikasikan Keterampilan
            </button>
        </form>
    </div>
</div>

<style>
    .tab-btn {
        background: none;
        border: none;
        color: var(--text-muted);
        padding: 0.75rem 1.25rem;
        font-weight: 600;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }

    .tab-btn:hover {
        color: var(--text-main);
    }

    .tab-active {
        color: var(--primary-color) !important;
        border-bottom-color: var(--primary-color) !important;
    }

    .filter-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 0.35rem 1rem;
        border-radius: 99px;
        cursor: pointer;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .filter-btn:hover,
    .filter-active {
        background: var(--primary-color);
        color: white !important;
        border-color: var(--primary-color);
    }

    .skill-card:hover .glass-card {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
    }
</style>

<script>
    function switchTab(id) {
        document.querySelectorAll('.tab-content').forEach(t => t.style.display = 'none');
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('tab-active'));
        document.getElementById(id).style.display = 'block';
        event.currentTarget.classList.add('tab-active');
    }

    function filterSkills(skillId) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('filter-active'));
        event.currentTarget.classList.add('filter-active');
        document.querySelectorAll('.skill-card').forEach(card => {
            card.style.display = (skillId === 'all' || card.dataset.skillId === skillId) ? '' : 'none';
        });
    }
</script>
=======
    </div>

    <!-- Controls -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap; align-items: center;">
        <div style="flex: 1; min-width: 250px;">
            <select id="majorSelect" style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; background: rgba(0,0,0,0.1); border: 1px solid var(--border-color, rgba(255,255,255,0.1)); color: inherit; font-family: inherit; font-size: 1rem; outline: none; cursor: pointer;">
                <option value="Web Development" style="color: #000;">Web Development</option>
                <option value="Desain Grafis" style="color: #000;">Desain Grafis</option>
                <option value="Digital Marketing" style="color: #000;">Digital Marketing</option>
                <option value="Bahasa Inggris" style="color: #000;">Bahasa Inggris</option>
                <option value="Public Speaking" style="color: #000;">Public Speaking</option>
            </select>
        </div>
        <button id="addNoteBtn" class="btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border: none; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;">
            <i class="fa-solid fa-plus"></i> Tambah Catatan
        </button>
    </div>

    <div id="notesStatus" style="margin-bottom: 1.5rem; font-size: 0.95rem; color: var(--text-muted);">
        Menampilkan catatan untuk jurusan <strong id="currentMajorLabel" style="color: inherit;">Web Development</strong> (<span id="noteCount">0</span>/5)
    </div>

    <!-- Notes Grid -->
    <div id="notesGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Notes will be injected here via JS -->
    </div>
</div>

<!-- Modal Add/Edit Note -->
<div id="noteModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.7); z-index: 5000; align-items: center; justify-content: center; padding: 1rem;">
    <div class="glass-card" style="width: 100%; max-width: 500px; margin: 0; position: relative;">
        <button onclick="closeModal()" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: var(--text-muted); font-size: 1.5rem; cursor: pointer; transition: color 0.2s;" onmouseover="this.style.color='inherit'" onmouseout="this.style.color='var(--text-muted)'">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h2 id="modalTitle" class="card-title" style="font-size: 1.5rem; margin-bottom: 1.5rem;">Tambah Catatan</h2>
        
        <input type="hidden" id="noteId">
        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Judul Catatan</label>
            <input type="text" id="noteTitle" placeholder="Misal: Rangkuman Jaringan Dasar" style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.1); color: inherit; font-family: inherit; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='rgba(255,255,255,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'" required>
        </div>
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.9rem;">Isi Catatan</label>
            <textarea id="noteContent" rows="6" placeholder="Tulis detail catatan Anda di sini..." style="width: 100%; padding: 0.75rem; border-radius: 0.5rem; background: rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.1); color: inherit; font-family: inherit; resize: vertical; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='rgba(255,255,255,0.3)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'" required></textarea>
        </div>
        
        <button onclick="saveNote()" class="btn-primary" style="width: 100%; padding: 0.75rem; border: none; border-radius: 0.5rem; font-size: 1rem; cursor: pointer;">
            <i class="fa-solid fa-save" style="margin-right: 0.5rem;"></i> Simpan Catatan
        </button>
    </div>
</div>
>>>>>>> 5708c0c20789965cd7ed7c6ec7a7c2316fc69942
