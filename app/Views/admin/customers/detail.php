<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
                <h3 class="card-title text-white"><i class="fas fa-user me-2"></i>Profil Customer</h3>
            </div>
            <div class="card-body text-center">
                <?php if ($customer['avatar']): ?>
                    <img src="<?= esc($customer['avatar']) ?>" style="width:80px;height:80px;border-radius:50%;object-fit:cover;" class="mb-3">
                <?php else: ?>
                    <div style="width:80px;height:80px;background:#e2e8f0;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;"><i class="fas fa-user fa-2x text-muted"></i></div>
                <?php endif; ?>
                <h5 class="fw-bold"><?= esc($customer['nama']) ?></h5>
                <p class="text-muted"><?= esc($customer['email']) ?></p>
                <span class="badge badge-success"><?= ucfirst($customer['role']) ?></span>
                <hr>
                <small class="text-muted">Terdaftar: <?= date('d/m/Y H:i', strtotime($customer['created_at'])) ?></small>
            </div>
        </div>
        <a href="<?= base_url('admin/customers') ?>" class="btn btn-secondary w-100"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Riwayat Pesanan</h5></div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                    <p class="text-center text-muted py-4">Belum ada pesanan</p>
                <?php else: ?>
                    <table class="table table-sm table-hover">
                        <thead><tr><th>No. Pesanan</th><th>Tanggal</th><th>Total</th><th>Status Bayar</th></tr></thead>
                        <tbody>
                            <?php foreach ($orders as $o): ?>
                            <tr>
                                <td><strong><?= esc($o['order_number']) ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($o['created_at'])) ?></td>
                                <td>Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                                <td>
                                    <?php
                                    $badge = match($o['payment_status']) {
                                        'paid' => 'badge-success', 'pending' => 'badge-warning',
                                        default => 'badge-danger'
                                    };
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= ucfirst($o['payment_status']) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
