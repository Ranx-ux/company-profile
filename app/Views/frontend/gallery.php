<?= $this->include('frontend/layout/header') ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

<div class="page-header">
    <div class="container text-white text-center position-relative" style="z-index:1;padding-top:20px;">
        <div class="section-label mx-auto mb-3" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">
            <i class="fas fa-images fa-xs"></i> Dokumentasi
        </div>
        <h1 style="font-size:2.5rem;font-weight:800;letter-spacing:-0.5px;" data-aos="fade-down">Galeri Kegiatan</h1>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Galeri</li>
            </ol>
        </nav>
    </div>
</div>

<div style="background:#f8fafc;padding:24px 0;border-bottom:1px solid var(--border);">
    <div class="container">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <?php foreach (array_unique(array_column($gallery, 'kategori')) as $cat): ?>
            <button class="filter-btn" data-filter="<?= esc($cat) ?>"><?= esc($cat) ?></button>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<style>
.filter-btn { padding:8px 20px;border-radius:50px;font-size:0.85rem;font-weight:600;border:1.5px solid var(--border);background:#fff;color:var(--gray);cursor:pointer;transition:all 0.25s; }
.filter-btn:hover,.filter-btn.active { background:var(--primary);color:#fff;border-color:var(--primary); }
</style>

<section style="padding:70px 0 90px;background:#f8fafc;">
    <div class="container">
        <div class="row g-3" id="galleryGrid">
            <?php foreach ($gallery as $i => $item): ?>
            <div class="col-lg-4 col-md-6 gallery-filter-item" data-category="<?= esc($item['kategori']) ?>" data-aos="zoom-in" data-aos-delay="<?= ($i % 3) * 80 ?>">
                <div class="gallery-item">
                    <?php if (!empty($item['gambar'])): ?>
                        <a href="<?= base_url('uploads/gallery/' . $item['gambar']) ?>" data-lightbox="gallery" data-title="<?= esc($item['judul']) ?>">
                            <img src="<?= base_url('uploads/gallery/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>">
                        </a>
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
        <?php if (empty($gallery)): ?>
        <div class="text-center py-5">
            <i class="fas fa-images fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada foto di galeri.</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.dataset.filter;
        document.querySelectorAll('.gallery-filter-item').forEach(item => {
            item.style.display = (filter === 'all' || item.dataset.category === filter) ? '' : 'none';
        });
    });
});
</script>

<?= $this->include('frontend/layout/footer') ?>
