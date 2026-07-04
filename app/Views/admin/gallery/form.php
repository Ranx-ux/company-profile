<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white">
            <i class="fas fa-<?= $item ? 'edit' : 'camera' ?> me-2"></i><?= esc($title) ?>
        </h3>
    </div>
    <div class="card-body">
        <form action="<?= $item ? base_url('admin/gallery/update/' . $item['id']) : base_url('admin/gallery/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Judul Foto <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control" value="<?= esc(old('judul', $item['judul'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3"><?= esc(old('deskripsi', $item['deskripsi'] ?? '')) ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $cats = ['Event', 'Kegiatan', 'Prestasi', 'Fasilitas', 'Kerjasama', 'Lainnya'];
                                    foreach ($cats as $cat):
                                        $selected = (old('kategori', $item['kategori'] ?? '') === $cat) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $cat ?>" <?= $selected ?>><?= $cat ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="fw-semibold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="aktif" <?= (old('status', $item['status'] ?? 'aktif') === 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                    <option value="nonaktif" <?= (old('status', $item['status'] ?? '') === 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Foto <?= !$item ? '<span class="text-danger">*</span>' : '' ?></label>
                        <div class="text-center mb-3">
                            <?php if (!empty($item['gambar'])): ?>
                                <img id="imgPreview" src="<?= base_url('uploads/gallery/' . $item['gambar']) ?>" alt="" class="img-thumbnail" style="max-height:200px;max-width:100%;">
                            <?php else: ?>
                                <div id="imgPlaceholder" style="height:200px;background:#f8f9fa;border:2px dashed #dee2e6;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-camera fa-2x mb-2"></i>
                                        <p class="small mb-0">Preview foto</p>
                                    </div>
                                </div>
                                <img id="imgPreview" src="" alt="" class="img-thumbnail d-none" style="max-height:200px;max-width:100%;">
                            <?php endif; ?>
                        </div>
                        <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImg(this)" <?= !$item ? 'required' : '' ?>>
                        <small class="text-muted">Format: JPG, PNG, GIF. Maks 2MB</small>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/gallery') ?>" class="btn btn-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </form>
    </div>
</div>

<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById('imgPreview');
            const placeholder = document.getElementById('imgPlaceholder');
            prev.src = e.target.result;
            prev.classList.remove('d-none');
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
