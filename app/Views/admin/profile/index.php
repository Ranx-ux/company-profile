<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-building me-2"></i>Profil Perusahaan</h3>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/profile/update') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Nama Perusahaan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_perusahaan" class="form-control" value="<?= esc($profile['nama_perusahaan'] ?? '') ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Deskripsi <span class="text-danger">*</span></label>
                        <textarea name="deskripsi" class="form-control" rows="4" required><?= esc($profile['deskripsi'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Visi</label>
                        <textarea name="visi" class="form-control" rows="3"><?= esc($profile['visi'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Misi</label>
                        <textarea name="misi" class="form-control" rows="4"><?= esc($profile['misi'] ?? '') ?></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Alamat <span class="text-danger">*</span></label>
                        <textarea name="alamat" class="form-control" rows="2" required><?= esc($profile['alamat'] ?? '') ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="fw-semibold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="<?= esc($profile['email'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="fw-semibold">Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="telepon" class="form-control" value="<?= esc($profile['telepon'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Website</label>
                        <input type="text" name="website" class="form-control" value="<?= esc($profile['website'] ?? '') ?>" placeholder="www.jayamakmur.co.id">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Logo Perusahaan</label>
                        <div class="text-center mb-3">
                            <?php if (!empty($profile['logo'])): ?>
                                <img src="<?= base_url('uploads/logo/' . $profile['logo']) ?>" alt="Logo" class="img-thumbnail" style="max-height:150px;max-width:100%;">
                            <?php else: ?>
                                <div style="height:150px;background:#f8f9fa;border:2px dashed #dee2e6;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-2x mb-2"></i>
                                        <p class="small mb-0">Belum ada logo</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewImage(this, 'logoPreview')">
                        <small class="text-muted">Format: JPG, PNG, GIF. Maks 2MB</small>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Simpan Perubahan
            </button>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary ms-2">
                <i class="fas fa-times me-2"></i>Batal
            </a>
        </form>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById(previewId);
            if (prev) prev.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>
