<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-users me-2"></i>Daftar Customer</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>#</th><th>Nama</th><th>Email</th><th>Tanggal Daftar</th><th width="100">Aksi</th></tr></thead>
                <tbody>
                    <?php if (empty($customers)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada customer</td></tr>
                    <?php else: ?>
                        <?php foreach ($customers as $i => $c): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <?php if ($c['avatar']): ?>
                                        <img src="<?= esc($c['avatar']) ?>" style="width:35px;height:35px;border-radius:50%;object-fit:cover;">
                                    <?php else: ?>
                                        <div style="width:35px;height:35px;background:#e2e8f0;border-radius:50%;display:flex;align-items:center;justify-content:center;"><i class="fas fa-user text-muted"></i></div>
                                    <?php endif; ?>
                                    <strong><?= esc($c['nama']) ?></strong>
                                </div>
                            </td>
                            <td><?= esc($c['email']) ?></td>
                            <td><?= date('d/m/Y', strtotime($c['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('admin/customers/detail/' . $c['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>
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
