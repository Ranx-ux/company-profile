<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-tag me-2"></i><?= esc($title) ?></h3>
    </div>
    <div class="card-body">
        <form action="<?= isset($category) ? base_url('admin/categories/update/' . $category['id']) : base_url('admin/categories/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="fw-semibold">Nama Kategori *</label>
                <input type="text" name="name" class="form-control" value="<?= old('name', $category['name'] ?? '') ?>" required>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
