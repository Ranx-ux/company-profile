<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white">
            <i class="fas fa-<?= $service ? 'edit' : 'plus' ?> me-2"></i><?= esc($title) ?>
        </h3>
    </div>
    <div class="card-body">
        <form action="<?= $service ? base_url('admin/services/update/' . $service['id']) : base_url('admin/services/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Nama Produk / Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="<?= esc(old('nama', $service['nama'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="5" required><?= esc(old('deskripsi', $service['deskripsi'] ?? '')) ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="fw-semibold">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-control" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php
                                    $cats = ['Konsultasi', 'Teknologi', 'Manajemen', 'Pemasaran', 'Keuangan', 'SDM'];
                                    foreach ($cats as $cat):
                                        $selected = (old('kategori', $service['kategori'] ?? '') === $cat) ? 'selected' : '';
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
                                    <option value="aktif" <?= (old('status', $service['status'] ?? 'aktif') === 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                    <option value="nonaktif" <?= (old('status', $service['status'] ?? '') === 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Icon (Font Awesome Class)</label>
                        <input type="text" name="icon" class="form-control" value="<?= esc(old('icon', $service['icon'] ?? 'fas fa-briefcase')) ?>" placeholder="fas fa-briefcase">
                        <small class="text-muted">Contoh: fas fa-briefcase, fas fa-laptop-code, fas fa-chart-line</small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Gambar</label>
                        <div class="text-center mb-3">
                            <?php if (!empty($service['gambar'])): ?>
                                <img id="imgPreview" src="<?= base_url('uploads/services/' . $service['gambar']) ?>" alt="" class="img-thumbnail" style="max-height:150px;max-width:100%;">
                            <?php else: ?>
                                <div id="imgPlaceholder" style="height:150px;background:#f8f9fa;border:2px dashed #dee2e6;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-2x mb-2"></i>
                                        <p class="small mb-0">Preview gambar</p>
                                    </div>
                                </div>
                                <img id="imgPreview" src="" alt="" class="img-thumbnail d-none" style="max-height:150px;max-width:100%;">
                            <?php endif; ?>
                        </div>
                        <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImg(this)">
                        <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/services') ?>" class="btn btn-secondary ms-2">
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
