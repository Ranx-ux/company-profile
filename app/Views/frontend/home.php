<?= $this->include('frontend/layout/header') ?>

<!-- ── HERO ── -->
<section class="hero-section" style="padding-top:80px;">
    <div class="hero-bg-shape shape-1"></div>
    <div class="hero-bg-shape shape-2"></div>
    <div class="container position-relative" style="z-index:2">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-badge">
                    <i class="fas fa-circle-check fa-xs"></i>
                    Perusahaan Terpercaya Sejak 2009
                </div>
                <h1 class="hero-title mb-4">
                    Solusi Bisnis<br>
                    <span class="highlight">Profesional</span><br>
                    untuk Anda
                </h1>
                <p class="hero-desc mb-5">
                    <?= esc(substr($profile['deskripsi'] ?? 'Kami berkomitmen memberikan produk dan layanan berkualitas tinggi.', 0, 180)) ?>
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?= base_url('services') ?>" class="btn-hero-primary">
                        <i class="fas fa-briefcase"></i> Lihat Layanan
                    </a>
                    <a href="<?= base_url('contact') ?>" class="btn-hero-outline">
                        <i class="fas fa-phone"></i> Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
                <div class="p-4" style="background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.1);border-radius:24px;backdrop-filter:blur(10px);">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="hero-stat-card">
                                <div class="hero-stat-number"><?= count($services) ?>+</div>
                                <div class="hero-stat-label">Produk & Layanan</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-card">
                                <div class="hero-stat-number">500+</div>
                                <div class="hero-stat-label">Klien Puas</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-card">
                                <div class="hero-stat-number">150+</div>
                                <div class="hero-stat-label">Tim Profesional</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="hero-stat-card">
                                <div class="hero-stat-number">15+</div>
                                <div class="hero-stat-label">Tahun Pengalaman</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 p-3 d-flex align-items-center gap-3" style="background:rgba(245,158,11,0.1);border-radius:14px;border:1px solid rgba(245,158,11,0.2);">
                        <div style="width:44px;height:44px;background:var(--secondary);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fas fa-award text-white"></i>
                        </div>
                        <div>
                            <div style="color:#fff;font-weight:700;font-size:0.9rem;">Penghargaan Nasional 2024</div>
                            <div style="color:rgba(255,255,255,0.55);font-size:0.78rem;">Perusahaan Terbaik Kategori Layanan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── SERVICES ── -->
<section class="py-6" style="padding:90px 0;background:#f8fafc;">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center" data-aos="fade-up">
                <div class="section-label"><i class="fas fa-briefcase fa-xs"></i> Layanan Kami</div>
                <h2 class="section-title">Produk & Layanan Unggulan</h2>
                <div class="divider-line center"></div>
                <p class="section-desc">Kami menyediakan berbagai solusi bisnis profesional yang dirancang untuk membantu perusahaan Anda berkembang.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($services as $i => $service): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="<?= esc($service['icon'] ?? 'fas fa-briefcase') ?>"></i>
                    </div>
                    <h5><?= esc($service['nama']) ?></h5>
                    <p><?= esc(substr($service['deskripsi'], 0, 110)) ?>...</p>
                    <span class="service-tag"><?= esc($service['kategori']) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('services') ?>" class="btn-primary-custom">
                Lihat Semua Layanan <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- ── STATS ── -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <?php
            $stats = [
                ['number' => '500+', 'label' => 'Klien Puas', 'icon' => 'fas fa-smile'],
                ['number' => '15+',  'label' => 'Tahun Pengalaman', 'icon' => 'fas fa-calendar-check'],
                ['number' => '150+', 'label' => 'Tim Profesional', 'icon' => 'fas fa-users'],
                ['number' => '50+',  'label' => 'Proyek Selesai', 'icon' => 'fas fa-check-circle'],
            ];
            foreach ($stats as $i => $s):
            ?>
            <div class="col-lg-3 col-6" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                <div class="stat-box">
                    <i class="<?= $s['icon'] ?> fa-2x mb-3" style="color:rgba(245,158,11,0.6)"></i>
                    <div class="stat-number"><?= $s['number'] ?></div>
                    <div class="stat-label"><?= $s['label'] ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── GALLERY ── -->
<section style="padding:90px 0;">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center" data-aos="fade-up">
                <div class="section-label"><i class="fas fa-images fa-xs"></i> Galeri</div>
                <h2 class="section-title">Momen Kegiatan Kami</h2>
                <div class="divider-line center"></div>
                <p class="section-desc">Dokumentasi berbagai kegiatan dan pencapaian perusahaan kami.</p>
            </div>
        </div>
        <div class="row g-3">
            <?php foreach ($gallery as $i => $item): ?>
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="gallery-item">
                    <?php if (!empty($item['gambar'])): ?>
                        <img src="<?= base_url('uploads/gallery/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>">
                    <?php else: ?>
                        <div style="height:260px;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-image fa-3x" style="color:rgba(255,255,255,0.2)"></i>
                        </div>
                    <?php endif; ?>
                    <div class="gallery-overlay">
                        <div class="gallery-overlay-content">
                            <p><?= esc($item['judul']) ?></p>
                            <span><?= esc($item['kategori']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('gallery') ?>" class="btn-primary-custom">
                Lihat Semua Galeri <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- ── FEATURED PRODUCTS ── -->
<?php if (!empty($products)): ?>
<section style="padding:90px 0;background:#f8fafc;">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 text-center" data-aos="fade-up">
                <div class="section-label"><i class="fas fa-box fa-xs"></i> Produk Kami</div>
                <h2 class="section-title">Produk Unggulan</h2>
                <div class="divider-line center"></div>
                <p class="section-desc">Temukan produk berkualitas terbaik untuk kebutuhan Anda.</p>
            </div>
        </div>
        <div class="row g-4">
            <?php foreach ($products as $i => $product): ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i % 4) * 80 ?>">
                <div class="card border-0 shadow-sm h-100" style="border-radius:16px;overflow:hidden;transition:all 0.3s;">
                    <a href="<?= base_url('products/' . esc($product['slug'])) ?>" class="text-decoration-none">
                        <div style="height:200px;overflow:hidden;">
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
                            <span class="fw-bold text-primary">Rp <?= number_format($product['price'], 0, ',', '.') ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="<?= base_url('products') ?>" class="btn-primary-custom">
                Lihat Semua Produk <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ── CTA ── -->
<section class="cta-section py-5">
    <div class="container py-4 text-center text-white" data-aos="fade-up">
        <div class="section-label mx-auto mb-3" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">
            <i class="fas fa-handshake fa-xs"></i> Mulai Kerjasama
        </div>
        <h2 style="font-size:2.2rem;font-weight:800;letter-spacing:-0.5px;" class="mb-3">
            Siap Membawa Bisnis Anda<br>ke Level Berikutnya?
        </h2>
        <p style="color:rgba(255,255,255,0.7);font-size:1rem;" class="mb-5">
            Konsultasikan kebutuhan bisnis Anda dengan tim profesional kami.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="<?= base_url('contact') ?>" class="btn-hero-primary">
                <i class="fas fa-envelope"></i> Hubungi Kami Sekarang
            </a>
            <a href="<?= base_url('about') ?>" class="btn-hero-outline">
                <i class="fas fa-info-circle"></i> Pelajari Lebih Lanjut
            </a>
        </div>
    </div>
</section>

<?= $this->include('frontend/layout/footer') ?>
