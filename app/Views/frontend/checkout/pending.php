<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up">Pembayaran Pending</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Pembayaran Pending</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Pending Payment Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6" data-aos="fade-up">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <div style="width:80px;height:80px;background:linear-gradient(135deg,#f59e0b,#fbbf24);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="fas fa-clock fa-2x text-white"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2">Pembayaran Menunggu</h4>
                        <p class="text-muted mb-3">Pesanan Anda telah dibuat, namun token pembayaran belum tersedia.</p>

                        <div class="p-3 mb-4" style="background:#f8fafc;border-radius:12px;">
                            <p class="mb-1">No. Pesanan: <strong><?= esc($order['order_number']) ?></strong></p>
                            <p class="mb-0">Total: <strong class="text-primary">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></strong></p>
                        </div>

                        <p class="text-muted small">Tim kami akan menghubungi Anda jika diperlukan. Anda juga dapat menghubungi customer service untuk bantuan lebih lanjut.</p>

                        <div class="d-flex gap-3 justify-content-center mt-4">
                            <a href="<?= base_url() ?>" class="btn btn-outline-primary">
                                <i class="fas fa-home"></i> Kembali ke Beranda
                            </a>
                            <a href="<?= base_url('contact') ?>" class="btn btn-primary">
                                <i class="fas fa-headset"></i> Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('frontend/layout/footer') ?>
