<!-- Footer -->
<footer class="pt-5 pb-0 mt-0">
    <div class="container py-4">
        <div class="row g-5">
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,var(--secondary),#fbbf24);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-building" style="color:#fff;font-size:1rem;"></i>
                    </div>
                    <span style="font-weight:800;color:#fff;font-size:1.1rem;"><?= esc($profile['nama_perusahaan'] ?? 'PT Jaya Makmur') ?><span style="color:var(--secondary)">.</span></span>
                </div>
                <p style="font-size:0.88rem;line-height:1.8;color:rgba(255,255,255,0.55);"><?= esc(substr($profile['deskripsi'] ?? '', 0, 160)) ?>...</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="social-btn"><i class="fab fa-facebook-f fa-sm"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-instagram fa-sm"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-linkedin-in fa-sm"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-youtube fa-sm"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6>Navigasi</h6>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="<?= base_url() ?>"><i class="fas fa-chevron-right me-1" style="font-size:0.65rem;color:var(--secondary)"></i>Beranda</a></li>
                    <li><a href="<?= base_url('about') ?>"><i class="fas fa-chevron-right me-1" style="font-size:0.65rem;color:var(--secondary)"></i>Tentang Kami</a></li>
                    <li><a href="<?= base_url('services') ?>"><i class="fas fa-chevron-right me-1" style="font-size:0.65rem;color:var(--secondary)"></i>Layanan</a></li>
                    <li><a href="<?= base_url('gallery') ?>"><i class="fas fa-chevron-right me-1" style="font-size:0.65rem;color:var(--secondary)"></i>Galeri</a></li>
                    <li><a href="<?= base_url('contact') ?>"><i class="fas fa-chevron-right me-1" style="font-size:0.65rem;color:var(--secondary)"></i>Kontak</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-6">
                <h6>Kontak</h6>
                <ul class="list-unstyled d-flex flex-column gap-3">
                    <li class="d-flex gap-2">
                        <i class="fas fa-map-marker-alt mt-1" style="color:var(--secondary);min-width:14px;font-size:0.85rem;"></i>
                        <span style="font-size:0.85rem;"><?= esc($profile['alamat'] ?? '-') ?></span>
                    </li>
                    <li class="d-flex gap-2 align-items-center">
                        <i class="fas fa-phone" style="color:var(--secondary);min-width:14px;font-size:0.85rem;"></i>
                        <span style="font-size:0.85rem;"><?= esc($profile['telepon'] ?? '-') ?></span>
                    </li>
                    <li class="d-flex gap-2 align-items-center">
                        <i class="fas fa-envelope" style="color:var(--secondary);min-width:14px;font-size:0.85rem;"></i>
                        <span style="font-size:0.85rem;"><?= esc($profile['email'] ?? '-') ?></span>
                    </li>
                    <?php if (!empty($profile['website'])): ?>
                    <li class="d-flex gap-2 align-items-center">
                        <i class="fas fa-globe" style="color:var(--secondary);min-width:14px;font-size:0.85rem;"></i>
                        <span style="font-size:0.85rem;"><?= esc($profile['website']) ?></span>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6>Jam Operasional</h6>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li class="d-flex justify-content-between" style="font-size:0.85rem;">
                        <span style="color:rgba(255,255,255,0.55)">Senin – Jumat</span>
                        <span style="color:#fff;font-weight:600;">08.00 – 17.00</span>
                    </li>
                    <li class="d-flex justify-content-between" style="font-size:0.85rem;">
                        <span style="color:rgba(255,255,255,0.55)">Sabtu</span>
                        <span style="color:#fff;font-weight:600;">08.00 – 13.00</span>
                    </li>
                    <li class="d-flex justify-content-between" style="font-size:0.85rem;">
                        <span style="color:rgba(255,255,255,0.55)">Minggu</span>
                        <span style="color:#e74c3c;font-weight:600;">Tutup</span>
                    </li>
                </ul>
                <div class="mt-4 p-3" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);border-radius:12px;">
                    <p style="font-size:0.8rem;color:rgba(255,255,255,0.7);margin:0;">Butuh bantuan segera?</p>
                    <a href="<?= base_url('contact') ?>" style="color:var(--secondary);font-weight:700;font-size:0.88rem;text-decoration:none;">Hubungi Kami →</a>
                </div>
            </div>
        </div>
    </div>
    <hr class="footer-divider my-0">
    <div class="py-3">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
            <small style="color:rgba(255,255,255,0.4);">&copy; <?= date('Y') ?> <?= esc($profile['nama_perusahaan'] ?? 'PT Jaya Makmur') ?>. All rights reserved.</small>
            <small style="color:rgba(255,255,255,0.3);">Built with CodeIgniter 4</small>
        </div>
    </div>
</footer>

<!-- Scroll to Top -->
<button id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <i class="fas fa-chevron-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true, offset: 60 });
    window.addEventListener('scroll', () => {
        const btn = document.getElementById('scrollTop');
        btn.style.display = window.scrollY > 400 ? 'flex' : 'none';
    });
</script>
</body>
</html>
