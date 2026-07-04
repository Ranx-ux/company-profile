<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-tags me-2"></i>Daftar Kategori</h3>
        <div class="card-tools">
            <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-sm btn-light"><i class="fas fa-plus me-1"></i>Tambah Kategori</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead><tr><th>#</th><th>Nama Kategori</th><th>Slug</th><th width="150">Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($categories)): ?>
                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada kategori</td></tr>
                <?php else: ?>
                    <?php foreach ($categories as $i => $cat): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($cat['name']) ?></td>
                        <td><code><?= esc($cat['slug']) ?></code></td>
                        <td>
                            <a href="<?= base_url('admin/categories/edit/' . $cat['id']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/categories/delete/' . $cat['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kategori ini?')"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
