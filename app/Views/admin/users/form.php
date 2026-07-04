<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white">
            <i class="fas fa-<?= $user ? 'user-edit' : 'user-plus' ?> me-2"></i><?= esc($title) ?>
        </h3>
    </div>
    <div class="card-body">
        <form action="<?= $user ? base_url('admin/users/update/' . $user['id']) : base_url('admin/users/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama" class="form-control" value="<?= esc(old('nama', $user['nama'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= esc(old('email', $user['email'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">
                            Password <?= $user ? '<small class="text-muted fw-normal">(kosongkan jika tidak ingin mengubah)</small>' : '<span class="text-danger">*</span>' ?>
                        </label>
                        <div class="input-group">
                            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Min. 6 karakter" <?= !$user ? 'required' : '' ?>>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="fw-semibold">Role <span class="text-danger">*</span></label>
                                <select name="role" class="form-control" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="superadmin" <?= (old('role', $user['role'] ?? '') === 'superadmin') ? 'selected' : '' ?>>Super Admin</option>
                                    <option value="admin" <?= (old('role', $user['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="fw-semibold">Status</label>
                                <select name="status" class="form-control">
                                    <option value="aktif" <?= (old('status', $user['status'] ?? 'aktif') === 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                    <option value="nonaktif" <?= (old('status', $user['status'] ?? '') === 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Foto Profil</label>
                        <div class="text-center mb-3">
                            <?php if (!empty($user['foto'])): ?>
                                <img id="imgPreview" src="<?= base_url('uploads/users/' . $user['foto']) ?>" alt="" class="img-thumbnail rounded-circle" style="width:120px;height:120px;object-fit:cover;">
                            <?php else: ?>
                                <div id="imgPlaceholder" style="width:120px;height:120px;background:linear-gradient(135deg,#1a3c6e,#2d6a9f);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                                <img id="imgPreview" src="" alt="" class="img-thumbnail rounded-circle d-none" style="width:120px;height:120px;object-fit:cover;">
                            <?php endif; ?>
                        </div>
                        <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewImg(this)">
                        <small class="text-muted">Format: JPG, PNG. Maks 2MB</small>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Simpan
            </button>
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary ms-2">
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

function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>

<?= $this->endSection() ?>
