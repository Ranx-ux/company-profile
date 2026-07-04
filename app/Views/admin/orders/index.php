<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
        <h3 class="card-title text-white"><i class="fas fa-shopping-bag me-2"></i>Daftar Pesanan</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No. Pesanan</th><th>Tanggal</th><th>Total</th><th>Status Bayar</th><th>Status Order</th><th width="100">Aksi</th></tr></thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Belum ada pesanan</td></tr>
                    <?php else: ?>
                        <?php foreach ($orders as $o): ?>
                        <tr>
                            <td><strong><?= esc($o['order_number']) ?></strong></td>
                            <td><?= date('d/m/Y H:i', strtotime($o['created_at'])) ?></td>
                            <td>Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></td>
                            <td>
                                <?php
                                $payBadge = match($o['payment_status']) {
                                    'paid' => 'badge-success', 'pending' => 'badge-warning',
                                    'failed','expired','cancelled' => 'badge-danger', default => 'badge-secondary'
                                };
                                ?>
                                <span class="badge <?= $payBadge ?>"><?= ucfirst($o['payment_status']) ?></span>
                            </td>
                            <td>
                                <?php
                                $ordBadge = match($o['order_status']) {
                                    'delivered' => 'badge-success', 'shipped','processing' => 'badge-info',
                                    'cancelled' => 'badge-danger', default => 'badge-secondary'
                                };
                                ?>
                                <span class="badge <?= $ordBadge ?>"><?= ucfirst($o['order_status']) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/orders/detail/' . $o['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>
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
