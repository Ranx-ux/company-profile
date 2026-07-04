<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-box me-2"></i>Daftar Produk</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/products/create') ?>" class="btn btn-sm btn-light"><i class="fas fa-plus me-1"></i>Tambah Produk</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>#</th><th>Thumbnail</th><th>Nama</th><th>Kategori</th><th>Harga</th><th>Stok</th><th width="120">Aksi</th></tr></thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr><td colspan="7" class="text-center text-muted py-4">Belum ada produk</td></tr>
                    <?php else: ?>
                        <?php foreach ($products as $i => $p): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <?php if ($p['thumbnail']): ?>
                                    <img src="<?= base_url('uploads/products/' . $p['thumbnail']) ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                                <?php else: ?>
                                    <div style="width:50px;height:50px;background:#f1f5f9;border-radius:8px;display:flex;align-items:center;justify-content:center;"><i class="fas fa-image text-muted"></i></div>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= esc($p['name']) ?></strong></td>
                            <td><span class="badge badge-info"><?= esc($p['category_name'] ?? '-') ?></span></td>
                            <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                            <td><span class="badge <?= $p['stock'] > 0 ? 'badge-success' : 'badge-danger' ?>"><?= $p['stock'] ?></span></td>
                            <td>
                                <a href="<?= base_url('admin/products/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="<?= base_url('admin/products/delete/' . $p['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?')"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
