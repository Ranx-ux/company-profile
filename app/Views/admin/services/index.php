<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-briefcase me-2"></i>Kelola Produk & Layanan</h3>
        <a href="<?= base_url('admin/services/create') ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Produk
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="servicesTable">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="15%">Gambar</th>
                        <th>Nama Produk / Layanan</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $i => $service): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?php if (!empty($service['gambar'])): ?>
                                <img src="<?= base_url('uploads/services/' . $service['gambar']) ?>" alt="" style="width:60px;height:45px;object-fit:cover;border-radius:6px;">
                            <?php else: ?>
                                <div style="width:60px;height:45px;background:linear-gradient(135deg,#1a3c6e,#2d6a9f);border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                    <i class="<?= esc($service['icon'] ?? 'fas fa-briefcase') ?> text-white small"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= esc($service['nama']) ?></strong>
                            <br><small class="text-muted"><?= esc(substr($service['deskripsi'], 0, 80)) ?>...</small>
                        </td>
                        <td><span class="badge badge-info"><?= esc($service['kategori']) ?></span></td>
                        <td>
                            <?php if ($service['status'] === 'aktif'): ?>
                                <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/services/edit/' . $service['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('admin/services/delete/' . $service['id']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus layanan ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($services)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data produk & layanan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
