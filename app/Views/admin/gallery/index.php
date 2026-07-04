<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-images me-2"></i>Kelola Galeri</h3>
        <a href="<?= base_url('admin/gallery/create') ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-plus me-1"></i>Tambah Foto
        </a>
    </div>
    <div class="card-body">
        <!-- Grid View -->
        <div class="row g-3 mb-4">
            <?php foreach ($gallery as $item): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card h-100" style="border-radius:10px;overflow:hidden;">
                    <?php if (!empty($item['gambar'])): ?>
                        <img src="<?= base_url('uploads/gallery/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>" style="height:160px;object-fit:cover;">
                    <?php else: ?>
                        <div style="height:160px;background:linear-gradient(135deg,#1a3c6e,#2d6a9f);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-image fa-2x text-white opacity-50"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body p-2">
                        <p class="fw-semibold small mb-1"><?= esc($item['judul']) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge badge-info small"><?= esc($item['kategori']) ?></span>
                            <span class="badge <?= $item['status'] === 'aktif' ? 'badge-success' : 'badge-secondary' ?> small"><?= esc($item['status']) ?></span>
                        </div>
                        <div class="mt-2 d-flex gap-1">
                            <a href="<?= base_url('admin/gallery/edit/' . $item['id']) ?>" class="btn btn-warning btn-sm flex-fill">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('admin/gallery/delete/' . $item['id']) ?>" class="btn btn-danger btn-sm flex-fill" onclick="return confirm('Yakin hapus foto ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (empty($gallery)): ?>
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-images fa-3x mb-3"></i>
                <p>Belum ada foto di galeri.</p>
                <a href="<?= base_url('admin/gallery/create') ?>" class="btn btn-primary btn-sm">Upload Foto Pertama</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
