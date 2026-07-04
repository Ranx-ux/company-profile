<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-box me-2"></i><?= esc($title) ?></h3>
    </div>
    <div class="card-body">
        <form action="<?= isset($product) ? base_url('admin/products/update/' . $product['id']) : base_url('admin/products/store') ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="fw-semibold">Nama Produk *</label>
                        <input type="text" name="name" class="form-control" value="<?= old('name', $product['name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="fw-semibold">Deskripsi *</label>
                        <textarea name="description" class="form-control" rows="5" required><?= old('description', $product['description'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="fw-semibold">Kategori *</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= old('category_id', $product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="fw-semibold">Harga *</label>
                                <input type="number" name="price" class="form-control" value="<?= old('price', $product['price'] ?? '') ?>" required min="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="fw-semibold">Stok *</label>
                                <input type="number" name="stock" class="form-control" value="<?= old('stock', $product['stock'] ?? '') ?>" required min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <h6 class="fw-bold mb-3">Thumbnail</h6>
            <?php if (isset($product) && $product['thumbnail']): ?>
                <img src="<?= base_url('uploads/products/' . $product['thumbnail']) ?>" class="mb-2" style="width:100px;height:100px;object-fit:cover;border-radius:8px;">
                <br>
            <?php endif; ?>
            <input type="file" name="thumbnail" class="form-control mb-3" accept="image/*">

            <h6 class="fw-bold mb-3">Gambar Tambahan</h6>
            <?php if (isset($images) && !empty($images)): ?>
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <?php foreach ($images as $img): ?>
                        <div class="position-relative" style="width:80px;height:80px;">
                            <img src="<?= base_url('uploads/products/' . $img['image']) ?>" style="width:80px;height:80px;object-fit:cover;border-radius:8px;">
                            <button type="button" class="btn btn-xs btn-danger position-absolute top-0 end-0 delete-img" data-id="<?= $img['id'] ?>" style="border-radius:50%;width:20px;height:20px;padding:0;font-size:0.6rem;"><i class="fas fa-times"></i></button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <input type="file" name="images[]" class="form-control" accept="image/*" multiple>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.querySelectorAll('.delete-img').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm('Hapus gambar ini?')) return;
        const id = this.dataset.id;
        fetch('<?= base_url('admin/products/delete-image/') ?>' + id, { method: 'POST' })
            .then(res => res.json())
            .then(data => { if (data.success) this.closest('.position-relative').remove(); });
    });
});
</script>

<?= $this->endSection() ?>
