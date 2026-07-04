<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
                <h3 class="card-title text-white"><i class="fas fa-receipt me-2"></i>Detail Pesanan #<?= esc($order['order_number']) ?></h3>
            </div>
            <div class="card-body">
                <h6 class="fw-bold mb-3">Item Pesanan</h6>
                <table class="table table-sm">
                    <thead><tr><th>Produk</th><th class="text-center">Qty</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td><?= esc($item['product_name'] ?? '-') ?></td>
                            <td class="text-center"><?= $item['qty'] ?></td>
                            <td class="text-end">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                            <td class="text-end fw-bold">Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr><th colspan="3" class="text-end">Total</th><th class="text-end">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></th></tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <?php if ($payment): ?>
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h5></div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><td class="fw-semibold" width="40%">Transaction ID</td><td><?= esc($payment['transaction_id'] ?? '-') ?></td></tr>
                    <tr><td class="fw-semibold">Payment Type</td><td><?= esc($payment['payment_type'] ?? '-') ?></td></tr>
                    <tr><td class="fw-semibold">Transaction Status</td><td><?= esc($payment['transaction_status'] ?? '-') ?></td></tr>
                    <tr><td class="fw-semibold">Gross Amount</td><td>Rp <?= number_format($payment['gross_amount'] ?? 0, 0, ',', '.') ?></td></tr>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Info Pesanan</h5></div>
            <div class="card-body">
                <table class="table table-sm table-borderless">
                    <tr><td class="fw-semibold">No. Pesanan</td><td><?= esc($order['order_number']) ?></td></tr>
                    <tr><td class="fw-semibold">Tanggal</td><td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td></tr>
                    <tr><td class="fw-semibold">Penerima</td><td><?= esc($order['receiver_name']) ?></td></tr>
                    <tr><td class="fw-semibold">Telepon</td><td><?= esc($order['phone']) ?></td></tr>
                    <tr><td class="fw-semibold">Email</td><td><?= esc($order['email']) ?></td></tr>
                    <tr><td class="fw-semibold">Alamat</td><td><?= esc($order['address']) ?><br><?= esc($order['city']) ?>, <?= esc($order['province']) ?> <?= esc($order['postal_code']) ?></td></tr>
                    <?php if ($order['notes']): ?>
                    <tr><td class="fw-semibold">Catatan</td><td><?= esc($order['notes']) ?></td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="fas fa-edit me-2"></i>Update Status</h5></div>
            <div class="card-body">
                <form action="<?= base_url('admin/orders/update-status/' . $order['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Status Pembayaran</label>
                        <select name="payment_status" class="form-control">
                            <?php foreach (['pending','paid','failed','expired','cancelled'] as $s): ?>
                                <option value="<?= $s ?>" <?= $order['payment_status'] == $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Status Order</label>
                        <select name="order_status" class="form-control">
                            <?php foreach (['pending','processing','shipped','delivered','cancelled'] as $s): ?>
                                <option value="<?= $s ?>" <?= $order['order_status'] == $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save me-1"></i>Update Status</button>
                </form>
            </div>
        </div>

        <a href="<?= base_url('admin/orders') ?>" class="btn btn-secondary w-100"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
    </div>
</div>

<?= $this->endSection() ?>
