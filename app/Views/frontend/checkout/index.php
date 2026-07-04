<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up">Checkout</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('cart') ?>">Keranjang</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Checkout Section -->
<section class="py-5">
    <div class="container">
        <form action="<?= base_url('checkout/process') ?>" method="post">
            <?= csrf_field() ?>
            <div class="row g-4">
                <!-- Shipping Form -->
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4"><i class="fas fa-truck me-2"></i>Informasi Pengiriman</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nama Penerima *</label>
                                    <input type="text" name="receiver_name" class="form-control" value="<?= old('receiver_name', session()->get('customer_name') ?? '') ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nomor Telepon *</label>
                                    <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Email *</label>
                                    <input type="email" name="email" class="form-control" value="<?= old('email', session()->get('customer_email') ?? '') ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Alamat Lengkap *</label>
                                    <textarea name="address" class="form-control" rows="3" required><?= old('address') ?></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kota *</label>
                                    <input type="text" name="city" class="form-control" value="<?= old('city') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Provinsi *</label>
                                    <input type="text" name="province" class="form-control" value="<?= old('province') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kode Pos *</label>
                                    <input type="text" name="postal_code" class="form-control" value="<?= old('postal_code') ?>" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Catatan Pesanan</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Catatan tambahan (opsional)"><?= old('notes') ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4"><i class="fas fa-receipt me-2"></i>Ringkasan Pesanan</h5>

                            <?php foreach ($items as $item): ?>
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom">
                                <div>
                                    <div class="fw-semibold"><?= esc($item['name']) ?></div>
                                    <small class="text-muted"><?= $item['qty'] ?> x Rp <?= number_format($item['price'], 0, ',', '.') ?></small>
                                </div>
                                <span class="fw-semibold">Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></span>
                            </div>
                            <?php endforeach; ?>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Ongkir</span>
                                <span class="text-muted fst-italic">Dihitung kemudian</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold fs-5">Total Pembayaran</span>
                                <span class="fw-bold text-primary fs-5">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>

                            <button type="submit" class="btn-hero-primary w-100 justify-content-center" style="border:none;cursor:pointer;">
                                <i class="fas fa-credit-card"></i> Bayar dengan Midtrans
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?= $this->include('frontend/layout/footer') ?>
