<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up">Keranjang Belanja</h1>
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Keranjang</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section -->
<section class="py-5">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
            <div class="text-center py-5" data-aos="fade-up">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Keranjang Anda Kosong</h5>
                <p class="text-muted">Belum ada produk di keranjang belanja Anda.</p>
                <a href="<?= base_url('products') ?>" class="btn-hero-primary" style="text-decoration:none;">
                    <i class="fas fa-shopping-bag"></i> Mulai Belanja
                </a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <!-- Cart Items -->
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th class="text-center" width="120">Qty</th>
                                            <th class="text-end" width="150">Harga</th>
                                            <th class="text-end" width="150">Subtotal</th>
                                            <th width="50"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $productId => $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <div style="width:60px;height:60px;border-radius:10px;overflow:hidden;flex-shrink:0;">
                                                        <?php if (!empty($item['thumbnail'])): ?>
                                                            <img src="<?= base_url('uploads/products/' . $item['thumbnail']) ?>" class="w-100 h-100" style="object-fit:cover;">
                                                        <?php else: ?>
                                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:#f1f5f9;">
                                                                <i class="fas fa-box text-muted"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <a href="<?= base_url('products/' . esc($item['slug'])) ?>" class="text-decoration-none fw-semibold text-dark"><?= esc($item['name']) ?></a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="input-group input-group-sm" style="width:100px;margin:auto;">
                                                    <button class="btn btn-outline-secondary btn-qty" data-id="<?= $productId ?>" data-delta="-1" type="button">-</button>
                                                    <input type="text" class="form-control text-center qty-display" data-id="<?= $productId ?>" value="<?= $item['qty'] ?>" readonly>
                                                    <button class="btn btn-outline-secondary btn-qty" data-id="<?= $productId ?>" data-delta="1" type="button">+</button>
                                                </div>
                                            </td>
                                            <td class="text-end">Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                                            <td class="text-end fw-bold item-subtotal" data-id="<?= $productId ?>">Rp <?= number_format($item['price'] * $item['qty'], 0, ',', '.') ?></td>
                                            <td class="text-center">
                                                <a href="<?= base_url('cart/remove/' . $productId) ?>" class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="card border-0 shadow-sm" style="border-radius:16px;">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Item</span>
                                <span class="fw-semibold"><?= count($items) ?> produk</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-primary" style="font-size:1.3rem;" id="cartTotal">Rp <?= number_format($total, 0, ',', '.') ?></span>
                            </div>
                            <a href="<?= base_url('checkout') ?>" class="btn-hero-primary w-100 justify-content-center" style="text-decoration:none;border:none;cursor:pointer;">
                                <i class="fas fa-credit-card"></i> Lanjut Checkout
                            </a>
                            <a href="<?= base_url('products') ?>" class="d-block text-center mt-3 text-decoration-none text-muted">
                                <i class="fas fa-arrow-left"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.querySelectorAll('.btn-qty').forEach(btn => {
    btn.addEventListener('click', function() {
        const productId = this.dataset.id;
        const delta = parseInt(this.dataset.delta);
        const display = document.querySelector('.qty-display[data-id="' + productId + '"]');
        let qty = parseInt(display.value) + delta;
        if (qty < 1) qty = 1;

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('qty', qty);

        fetch('<?= base_url('cart/update') ?>', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                display.value = qty;
                document.getElementById('cartTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(data.total);
            }
        });
    });
});
</script>

<?= $this->include('frontend/layout/footer') ?>
