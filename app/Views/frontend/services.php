<?= $this->include('frontend/layout/header') ?>

<div class="page-header bg-light-page">
    <div class="container text-white text-center position-relative" style="z-index:1;padding-top:20px;">
        <div class="section-label mx-auto mb-3" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">
            <i class="fas fa-briefcase fa-xs"></i> Apa yang Kami Tawarkan
        </div>
        <h1 style="font-size:2.5rem;font-weight:800;letter-spacing:-0.5px;" data-aos="fade-down">Produk & Layanan</h1>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Layanan</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Filter -->
<div style="background:#f8fafc;padding:24px 0;border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <?php foreach (array_unique(array_column($services, 'kategori')) as $cat): ?>
            <button class="filter-btn" data-filter="<?= esc($cat) ?>"><?= esc($cat) ?></button>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
.filter-btn {
    padding: 8px 20px; border-radius: 50px; font-size: 0.85rem; font-weight: 600;
    border: 1.5px solid var(--border); background: #fff; color: var(--gray);
    cursor: pointer; transition: all 0.25s;
}
.filter-btn:hover, .filter-btn.active {
    background: var(--primary); color: #fff; border-color: var(--primary);
}
</style>

<section style="padding:70px 0 90px;background:#f8fafc;">
    <div class="container">
        <div class="row g-4" id="servicesGrid">
            <?php foreach ($services as $i => $service): ?>
            <div class="col-lg-4 col-md-6 service-item" data-category="<?= esc($service['kategori']) ?>" data-aos="fade-up" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="service-card h-100">
                    <?php if (!empty($service['gambar'])): ?>
                        <img src="<?= base_url('uploads/services/' . $service['gambar']) ?>" alt="<?= esc($service['nama']) ?>" style="width:100%;height:180px;object-fit:cover;border-radius:14px;margin-bottom:20px;">
                    <?php else: ?>
                        <div style="height:160px;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:14px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;">
                            <i class="<?= esc($service['icon'] ?? 'fas fa-briefcase') ?> fa-3x" style="color:rgba(255,255,255,0.3)"></i>
                        </div>
                    <?php endif; ?>
                    <div class="service-icon">
                        <i class="<?= esc($service['icon'] ?? 'fas fa-briefcase') ?>"></i>
                    </div>
                    <h5><?= esc($service['nama']) ?></h5>
                    <p><?= esc($service['deskripsi']) ?></p>
                    <span class="service-tag"><?= esc($service['kategori']) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($services)): ?>
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada layanan tersedia.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.dataset.filter;
        document.querySelectorAll('.service-item').forEach(item => {
            item.style.display = (filter === 'all' || item.dataset.category === filter) ? '' : 'none';
        });
    });
});
</script>

<?= $this->include('frontend/layout/footer') ?>
