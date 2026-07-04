<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up">Pembayaran</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Pembayaran</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Payment Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <div style="width:80px;height:80px;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:50%;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="fas fa-credit-card fa-2x text-white"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2">Selesaikan Pembayaran</h4>
                        <p class="text-muted mb-1">No. Pesanan: <strong><?= esc($order['order_number']) ?></strong></p>
                        <p class="text-muted mb-4">Total: <strong class="text-primary">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong></p>

                        <?php if ($snap_token): ?>
                            <button id="pay-button" class="btn-hero-primary" style="border:none;cursor:pointer;">
                                <i class="fas fa-bolt"></i> Bayar Sekarang
                            </button>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> Token pembayaran belum tersedia. Silakan refresh halaman.
                            </div>
                            <a href="<?= base_url() ?>" class="btn btn-outline-primary">Kembali ke Beranda</a>
                        <?php endif; ?>

                        <div id="payment-status" class="mt-4" style="display:none;"></div>
                    </div>
                </div>

                <!-- Order Detail Summary -->
                <div class="card border-0 shadow-sm mt-4" style="border-radius:16px;">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Detail Pesanan</h6>
                        <table class="table table-sm">
                            <thead><tr><th>Produk</th><th class="text-center">Qty</th><th class="text-end">Subtotal</th></tr></thead>
                            <tbody>
                                <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td><?= esc($item['product_name'] ?? '-') ?></td>
                                    <td class="text-center"><?= $item['qty'] ?></td>
                                    <td class="text-end">Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr><th colspan="2" class="text-end">Total</th><th class="text-end">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></th></tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($snap_token): ?>
<!-- Midtrans Snap JS -->
<script src="<?= esc($snap_js_url) ?>" data-client-key="<?= esc($client_key) ?>"></script>
<script>
document.getElementById('pay-button').addEventListener('click', function() {
    snap.pay('<?= esc($snap_token) ?>', {
        onSuccess: function(result) {
            document.getElementById('payment-status').style.display = 'block';
            document.getElementById('payment-status').innerHTML = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> Pembayaran berhasil! Terima kasih.</div>';
            this.style.display = 'none';
        },
        onPending: function(result) {
            document.getElementById('payment-status').style.display = 'block';
            document.getElementById('payment-status').innerHTML = '<div class="alert alert-warning"><i class="fas fa-clock"></i> Pembayaran sedang diproses. Silakan selesaikan pembayaran Anda.</div>';
        },
        onError: function(result) {
            document.getElementById('payment-status').style.display = 'block';
            document.getElementById('payment-status').innerHTML = '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> Pembayaran gagal. Silakan coba lagi.</div>';
        },
        onClose: function() {
            document.getElementById('payment-status').style.display = 'block';
            document.getElementById('payment-status').innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle"></i> Anda menutup popup pembayaran. Anda dapat melanjutkan pembayaran nanti.</div>';
        }
    });
});

// Auto-trigger payment
setTimeout(function() {
    document.getElementById('pay-button').click();
}, 500);
</script>
<?php endif; ?>

<?= $this->include('frontend/layout/footer') ?>
