<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up"><?= esc($product['name']) ?></h1>
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('products') ?>">Produk</a></li>
                        <li class="breadcrumb-item active"><?= esc($product['name']) ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Product Detail -->
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="card border-0 shadow-sm" style="border-radius:20px;overflow:hidden;">
                    <!-- Main Image -->
                    <div id="mainImage" style="height:450px;overflow:hidden;">
                        <?php if (!empty($product['thumbnail'])): ?>
                            <img src="<?= base_url('uploads/products/' . $product['thumbnail']) ?>" alt="<?= esc($product['name']) ?>" class="w-100 h-100" style="object-fit:cover;" id="mainImg">
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,var(--primary),var(--accent));">
                                <i class="fas fa-box fa-5x" style="color:rgba(255,255,255,0.2)"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- Thumbnail Gallery -->
                    <?php if (!empty($images)): ?>
                    <div class="card-body pt-3">
                        <div class="d-flex gap-2 flex-wrap">
                            <?php if (!empty($product['thumbnail'])): ?>
                                <div class="border rounded" style="width:70px;height:70px;overflow:hidden;cursor:pointer;" onclick="changeImage(this, '<?= base_url('uploads/products/' . $product['thumbnail']) ?>')">
                                    <img src="<?= base_url('uploads/products/' . $product['thumbnail']) ?>" class="w-100 h-100" style="object-fit:cover;">
                                </div>
                            <?php endif; ?>
                            <?php foreach ($images as $img): ?>
                                <div class="border rounded" style="width:70px;height:70px;overflow:hidden;cursor:pointer;" onclick="changeImage(this, '<?= base_url('uploads/products/' . $img['image']) ?>')">
                                    <img src="<?= base_url('uploads/products/' . $img['image']) ?>" class="w-100 h-100" style="object-fit:cover;">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="mb-3">
                    <?php if (!empty($product['category_name'])): ?>
                        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2"><?= esc($product['category_name']) ?></span>
                    <?php endif; ?>
                </div>
                <h2 class="fw-bold mb-3" style="color:var(--primary);"><?= esc($product['name']) ?></h2>
                <h3 class="fw-bold mb-4" style="color:var(--secondary);">Rp <?= number_format($product['price'], 0, ',', '.') ?></h3>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="badge <?= $product['stock'] > 0 ? 'bg-success' : 'bg-danger' ?> px-3 py-2">
                        <?= $product['stock'] > 0 ? 'Stok: ' . $product['stock'] : 'Habis' ?>
                    </span>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold">Deskripsi Produk</h6>
                    <p class="text-muted" style="line-height:1.8;"><?= nl2br(esc($product['description'] ?? 'Belum ada deskripsi.')) ?></p>
                </div>

                <?php if ($product['stock'] > 0): ?>
                <form action="<?= base_url('cart/add') ?>" method="post" id="addToCartForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <label class="fw-semibold">Jumlah:</label>
                        <div class="input-group" style="width:140px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(-1)">-</button>
                            <input type="number" name="qty" id="qty" class="form-control text-center" value="1" min="1" max="<?= $product['stock'] ?>">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQty(1)">+</button>
                        </div>
                    </div>
                    <button type="submit" class="btn-hero-primary w-100 justify-content-center" style="border:none;cursor:pointer;" id="btnAddCart">
                        <i class="fas fa-shopping-cart"></i> Tambah ke Keranjang
                    </button>
                </form>
                <?php else: ?>
                <button class="btn btn-secondary w-100" disabled>
                    <i class="fas fa-ban"></i> Stok Habis
                </button>
                <?php endif; ?>

                <!-- Flash message for add to cart -->
                <div id="cartMessage" class="mt-3" style="display:none;"></div>
            </div>
        </div>
    </div>
</section>

<script>
function changeImage(el, src) {
    document.getElementById('mainImg').src = src;
    document.querySelectorAll('.border.rounded').forEach(e => e.style.borderColor = '#dee2e6');
    el.style.borderColor = 'var(--secondary)';
}

function changeQty(delta) {
    const input = document.getElementById('qty');
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > <?= $product['stock'] ?>) val = <?= $product['stock'] ?>;
    input.value = val;
}

// AJAX add to cart
document.getElementById('addToCartForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch('<?= base_url('cart/add') ?>', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('cartMessage');
        msg.style.display = 'block';
        if (data.success) {
            msg.innerHTML = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + data.message + '</div>';
            // Update cart badge
            document.querySelectorAll('.cart-count').forEach(el => el.textContent = data.count);
        } else {
            msg.innerHTML = '<div class="alert alert-danger"><i class="fas fa-times-circle"></i> ' + data.message + '</div>';
        }
        setTimeout(() => msg.style.display = 'none', 3000);
    });
});
</script>

<?= $this->include('frontend/layout/footer') ?>
