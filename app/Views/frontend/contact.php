<?= $this->include('frontend/layout/header') ?>

<div class="page-header">
    <div class="container text-white text-center position-relative" style="z-index:1;padding-top:20px;">
        <div class="section-label mx-auto mb-3" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">
            <i class="fas fa-envelope fa-xs"></i> Hubungi Kami
        </div>
        <h1 style="font-size:2.5rem;font-weight:800;letter-spacing:-0.5px;" data-aos="fade-down">Kontak</h1>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Kontak</li>
            </ol>
        </nav>
    </div>
</div>

<section style="padding:90px 0;">
    <div class="container">
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" style="border-radius:14px;border:none;background:#d1fae5;color:#065f46;">
            <i class="fas fa-check-circle fa-lg"></i>
            <span><?= session()->getFlashdata('success') ?></span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4" style="border-radius:14px;border:none;">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <div class="d-flex align-items-center gap-2"><i class="fas fa-exclamation-circle"></i><?= esc($error) ?></div>
            <?php endforeach; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="row g-5">
            <!-- Info -->
            <div class="col-lg-4" data-aos="fade-right">
                <div class="section-label"><i class="fas fa-info-circle fa-xs"></i> Info Kontak</div>
                <h2 class="section-title mt-2 mb-2">Kami Siap<br>Membantu Anda</h2>
                <div class="divider-line"></div>
                <p style="color:var(--gray);font-size:0.9rem;line-height:1.8;">Jangan ragu untuk menghubungi kami. Tim kami siap memberikan solusi terbaik untuk kebutuhan bisnis Anda.</p>

                <div class="d-flex flex-column gap-3 mt-4">
                    <?php
                    $contacts = [
                        ['icon'=>'fas fa-map-marker-alt','label'=>'Alamat','value'=>$profile['alamat'] ?? '-','color'=>'var(--secondary)'],
                        ['icon'=>'fas fa-phone','label'=>'Telepon','value'=>$profile['telepon'] ?? '-','color'=>'var(--accent)'],
                        ['icon'=>'fas fa-envelope','label'=>'Email','value'=>$profile['email'] ?? '-','color'=>'#10b981'],
                    ];
                    if (!empty($profile['website'])) {
                        $contacts[] = ['icon'=>'fas fa-globe','label'=>'Website','value'=>$profile['website'],'color'=>'#8b5cf6'];
                    }
                    foreach ($contacts as $c):
                    ?>
                    <div class="d-flex gap-3 p-3" style="background:#f8fafc;border-radius:14px;border:1px solid var(--border);">
                        <div style="width:44px;height:44px;background:<?= $c['color'] ?>1a;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="<?= $c['icon'] ?>" style="color:<?= $c['color'] ?>"></i>
                        </div>
                        <div>
                            <div style="font-size:0.72rem;color:var(--gray);font-weight:700;text-transform:uppercase;letter-spacing:0.5px;"><?= $c['label'] ?></div>
                            <div style="font-size:0.88rem;font-weight:600;color:var(--primary);margin-top:2px;"><?= esc($c['value']) ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-4">
                    <div style="font-size:0.8rem;color:var(--gray);font-weight:700;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;">Ikuti Kami</div>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f fa-sm"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram fa-sm"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-linkedin-in fa-sm"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-youtube fa-sm"></i></a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="col-lg-8" data-aos="fade-left">
                <div style="background:#fff;border-radius:24px;padding:40px;border:1px solid var(--border);box-shadow:0 4px 30px rgba(0,0,0,0.06);">
                    <h4 style="font-weight:800;color:var(--primary);margin-bottom:6px;">Kirim Pesan</h4>
                    <p style="color:var(--gray);font-size:0.88rem;margin-bottom:28px;">Isi formulir di bawah ini dan kami akan segera merespons.</p>
                    <form action="<?= base_url('contact/send') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control" style="border-radius:10px;border:1.5px solid var(--border);padding:12px 16px;font-size:0.9rem;" placeholder="Nama Anda" value="<?= old('nama') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" style="border-radius:10px;border:1.5px solid var(--border);padding:12px 16px;font-size:0.9rem;" placeholder="email@anda.com" value="<?= old('email') ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Subjek <span class="text-danger">*</span></label>
                                <input type="text" name="subjek" class="form-control" style="border-radius:10px;border:1.5px solid var(--border);padding:12px 16px;font-size:0.9rem;" placeholder="Subjek pesan Anda" value="<?= old('subjek') ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Pesan <span class="text-danger">*</span></label>
                                <textarea name="pesan" class="form-control" style="border-radius:10px;border:1.5px solid var(--border);padding:12px 16px;font-size:0.9rem;" rows="6" placeholder="Tulis pesan Anda di sini..." required><?= old('pesan') ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-primary-custom w-100 justify-content-center" style="padding:14px;">
                                    <i class="fas fa-paper-plane"></i> Kirim Pesan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map -->
        <div class="mt-5" data-aos="fade-up">
            <div style="border-radius:20px;overflow:hidden;border:1px solid var(--border);box-shadow:0 4px 20px rgba(0,0,0,0.06);">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.54388!2d106.7271!3d-6.2088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta!5e0!3m2!1sid!2sid!4v1234567890" width="100%" height="380" style="border:0;display:block;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

<?= $this->include('frontend/layout/footer') ?>
