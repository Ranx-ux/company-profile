<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-users-cog me-2"></i>Kelola User Admin</h3>
        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-user-plus me-1"></i>Tambah User
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">#</th>
                        <th width="10%">Foto</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $i => $user): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                            <?php if (!empty($user['foto'])): ?>
                                <img src="<?= base_url('uploads/users/' . $user['foto']) ?>" alt="" style="width:45px;height:45px;object-fit:cover;border-radius:50%;border:2px solid #dee2e6;">
                            <?php else: ?>
                                <div style="width:45px;height:45px;background:linear-gradient(135deg,#1a3c6e,#2d6a9f);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-user text-white small"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= esc($user['nama']) ?></strong>
                            <?php if ($user['id'] == session()->get('admin_id')): ?>
                                <span class="badge badge-primary ml-1">Anda</span>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($user['email']) ?></td>
                        <td>
                            <?php if ($user['role'] === 'superadmin'): ?>
                                <span class="badge badge-danger">Super Admin</span>
                            <?php else: ?>
                                <span class="badge badge-info">Admin</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($user['status'] === 'aktif'): ?>
                                <span class="badge badge-success">Aktif</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if ($user['id'] != session()->get('admin_id')): ?>
                            <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data user.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
