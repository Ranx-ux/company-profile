<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up">Produk Kami</h1>
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Produk</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Sidebar Filter -->
            <div class="col-lg-3" data-aos="fade-right">
                <div class="card border-0 shadow-sm" style="border-radius:16px;">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Kategori</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="<?= base_url('products') ?>" class="text-decoration-none <?= !$selectedCategory ? 'fw-bold text-primary' : 'text-dark' ?>">
                                    Semua Kategori
                                </a>
                            </li>
                            <?php foreach ($categories as $cat): ?>
                            <li class="mb-2">
                                <a href="<?= base_url('products?category=' . $cat['id']) ?>" class="text-decoration-none <?= $selectedCategory == $cat['id'] ? 'fw-bold text-primary' : 'text-dark' ?>">
                                    <?= esc($cat['name']) ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <hr>
                        <h5 class="fw-bold mb-3">Cari Produk</h5>
                        <form action="<?= base_url('products') ?>" method="get">
                            <?php if ($selectedCategory): ?>
                                <input type="hidden" name="category" value="<?= $selectedCategory ?>">
                            <?php endif; ?>
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Ketik nama produk..." value="<?= esc($keyword) ?>">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <?php if ($keyword): ?>
                    <p class="text-muted mb-3">Hasil pencarian: "<strong><?= esc($keyword) ?></strong>" — <?= count($products) ?> produk ditemukan</p>
                <?php endif; ?>

                <?php if (empty($products)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada produk</h5>
                        <p class="text-muted">Produk akan segera tersedia.</p>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <?php foreach ($products as $i => $product): ?>
                        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                            <div class="card border-0 shadow-sm h-100" style="border-radius:16px;overflow:hidden;transition:all 0.3s;">
                                <a href="<?= base_url('products/' . esc($product['slug'])) ?>" class="text-decoration-none">
                                    <div style="height:220px;overflow:hidden;">
                                        <?php if (!empty($product['thumbnail'])): ?>
                                            <img src="<?= base_url('uploads/products/' . $product['thumbnail']) ?>" alt="<?= esc($product['name']) ?>" class="w-100 h-100" style="object-fit:cover;transition:transform 0.4s;">
                                        <?php else: ?>
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,var(--primary),var(--accent));">
                                                <i class="fas fa-box fa-3x" style="color:rgba(255,255,255,0.3)"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($product['category_name'])): ?>
                                            <span class="badge bg-primary bg-opacity-10 text-primary mb-2"><?= esc($product['category_name']) ?></span>
                                        <?php endif; ?>
                                        <h6 class="fw-bold text-dark mb-1"><?= esc($product['name']) ?></h6>
                                        <p class="text-muted small mb-2"><?= esc(substr($product['description'] ?? '', 0, 60)) ?>...</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold text-primary" style="font-size:1.1rem;">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                                            <small class="text-muted">Stok: <?= $product['stock'] ?></small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-5 d-flex justify-content-center">
                        <?= $pager->links('products', 'default_full') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?= $this->include('frontend/layout/footer') ?>
