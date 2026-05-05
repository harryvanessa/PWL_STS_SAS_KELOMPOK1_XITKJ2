<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Pilihan Jurusan Siswa</h5>
                    <a href="<?= BASEURL; ?>/mentor" class="btn btn-sm btn-light">Kembali ke Dashboard</a>
                </div>
                <div class="card-body">
                    <?php Flasher::flash(); ?>

                    <!-- Stats Section -->
                    <?php if (!empty($data['stats'])): ?>
                        <div class="row mb-4">
                            <?php foreach ($data['stats'] as $stat): ?>
                                <div class="col-md-3 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($stat['major']); ?></h6>
                                            <h3 class="card-title"><?= htmlspecialchars($stat['total']); ?></h3>
                                            <small class="text-muted">Siswa</small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <hr class="my-4">
                    <?php endif; ?>

                    <!-- Major Selections Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jurusan yang Dipilih</th>
                                    <th>Aplikasi</th>
                                    <th>Tanggal Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['major_selections'])): ?>
                                    <?php $no = 1; foreach ($data['major_selections'] as $selection): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><strong><?= htmlspecialchars($selection['username']); ?></strong></td>
                                            <td><?= htmlspecialchars($selection['full_name'] ?? '-'); ?></td>
                                            <td>
                                                <span class="badge bg-info"><?= htmlspecialchars($selection['major']); ?></span>
                                            </td>
                                            <td><?= htmlspecialchars($selection['app']); ?></td>
                                            <td><?= date('d M Y H:i', strtotime($selection['created_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            Belum ada data pilihan jurusan
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
    
    .card {
        border: none;
        border-radius: 8px;
    }
    
    .badge {
        padding: 0.5em 0.75em;
        font-size: 0.85em;
    }
</style>
