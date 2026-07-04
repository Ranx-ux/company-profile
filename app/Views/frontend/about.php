<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<div class="page-header">
    <div class="container text-white text-center position-relative" style="z-index:1;padding-top:20px;">
        <div class="section-label mx-auto mb-3" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">
            <i class="fas fa-building fa-xs"></i> Profil Perusahaan
        </div>
        <h1 style="font-size:2.5rem;font-weight:800;letter-spacing:-0.5px;" data-aos="fade-down">Tentang Kami</h1>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="/">Beranda</a></li>
                <li class="breadcrumb-item active">Tentang Kami</li>
            </ol>
        </nav>
    </div>
</div>

<!-- About Content -->
<section style="padding:90px 0;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div style="background:linear-gradient(135deg,var(--primary),var(--primary-light));border-radius:24px;padding:50px;text-align:center;position:relative;overflow:hidden;">
                    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(255,255,255,0.05);border-radius:50%;"></div>
                    <?php if (!empty($profile['logo'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $profile['logo']) ?>" alt="Logo" style="max-width:180px;max-height:180px;object-fit:contain;border-radius:16px;">
                    <?php else: ?>
                        <div style="width:100px;height:100px;background:rgba(255,255,255,0.1);border-radius:24px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                            <i class="fas fa-building fa-3x" style="color:rgba(255,255,255,0.5)"></i>
                        </div>
                    <?php endif; ?>
                    <h3 style="color:#fff;font-weight:800;margin-top:20px;font-size:1.3rem;"><?= esc($profile['nama_perusahaan'] ?? 'PT Jaya Makmur') ?></h3>
                    <p style="color:rgba(255,255,255,0.6);font-size:0.85rem;">Berdiri sejak 2009</p>
                    <div class="row g-2 mt-3">
                        <?php
                        $mini = [['500+','Klien'],['15+','Tahun'],['150+','Tim'],['50+','Proyek']];
                        foreach ($mini as $m):
                        ?>
                        <div class="col-6">
                            <div style="background:rgba(255,255,255,0.08);border-radius:12px;padding:12px;">
                                <div style="font-size:1.4rem;font-weight:800;color:var(--secondary)"><?= $m[0] ?></div>
                                <div style="color:rgba(255,255,255,0.6);font-size:0.75rem"><?= $m[1] ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <div class="section-label"><i class="fas fa-info-circle fa-xs"></i> Siapa Kami</div>
                <h2 class="section-title"><?= esc($profile['nama_perusahaan'] ?? 'PT Jaya Makmur') ?></h2>
                <div class="divider-line"></div>
                <p style="color:var(--gray);line-height:1.9;font-size:0.95rem;"><?= nl2br(esc($profile['deskripsi'] ?? '')) ?></p>
                <div class="row g-3 mt-3">
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 p-3" style="background:#f8fafc;border-radius:14px;border:1px solid var(--border);">
                            <div style="width:42px;height:42px;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-map-marker-alt text-white fa-sm"></i>
                            </div>
                            <div>
                                <div style="font-size:0.75rem;color:var(--gray);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Alamat</div>
                                <div style="font-size:0.85rem;font-weight:600;color:var(--primary);margin-top:2px;"><?= esc($profile['alamat'] ?? '-') ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3 p-3" style="background:#f8fafc;border-radius:14px;border:1px solid var(--border);">
                            <div style="width:42px;height:42px;background:linear-gradient(135deg,var(--secondary),#fbbf24);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-phone text-white fa-sm"></i>
                            </div>
                            <div>
                                <div style="font-size:0.75rem;color:var(--gray);font-weight:600;text-transform:uppercase;letter-spacing:0.5px;">Telepon</div>
                                <div style="font-size:0.85rem;font-weight:600;color:var(--primary);margin-top:2px;"><?= esc($profile['telepon'] ?? '-') ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi -->
<section style="padding:0 0 90px;background:#f8fafc;">
    <div class="container" style="padding-top:70px;">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-label mx-auto"><i class="fas fa-compass fa-xs"></i> Arah Perusahaan</div>
            <h2 class="section-title mt-2">Visi & Misi</h2>
            <div class="divider-line center"></div>
        </div>
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div style="background:#fff;border-radius:20px;padding:36px;height:100%;border:1px solid var(--border);border-top:4px solid var(--secondary);">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="width:52px;height:52px;background:linear-gradient(135deg,var(--secondary),#fbbf24);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-eye text-white fa-lg"></i>
                        </div>
                        <h4 style="font-weight:800;color:var(--primary);margin:0;font-size:1.2rem;">Visi</h4>
                    </div>
                    <p style="color:var(--gray);line-height:1.9;font-size:0.95rem;"><?= nl2br(esc($profile['visi'] ?? 'Menjadi perusahaan terdepan dan terpercaya.')) ?></p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div style="background:#fff;border-radius:20px;padding:36px;height:100%;border:1px solid var(--border);border-top:4px solid var(--accent);">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div style="width:52px;height:52px;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:14px;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-bullseye text-white fa-lg"></i>
                        </div>
                        <h4 style="font-weight:800;color:var(--primary);margin:0;font-size:1.2rem;">Misi</h4>
                    </div>
                    <p style="color:var(--gray);line-height:1.9;font-size:0.95rem;"><?= nl2br(esc($profile['misi'] ?? 'Memberikan layanan berkualitas tinggi.')) ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section style="padding:0 0 90px;">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <div class="section-label mx-auto"><i class="fas fa-star fa-xs"></i> Nilai Kami</div>
            <h2 class="section-title mt-2">Nilai-Nilai Perusahaan</h2>
            <div class="divider-line center"></div>
        </div>
        <div class="row g-4 text-center">
            <?php
            $values = [
                ['icon'=>'fas fa-award','title'=>'Integritas','desc'=>'Menjunjung tinggi kejujuran dan etika dalam setiap tindakan bisnis','color'=>'var(--secondary)'],
                ['icon'=>'fas fa-lightbulb','title'=>'Inovasi','desc'=>'Mendorong kreativitas dan solusi inovatif untuk setiap tantangan','color'=>'var(--accent)'],
                ['icon'=>'fas fa-handshake','title'=>'Kolaborasi','desc'=>'Membangun kerjasama yang kuat dengan klien dan mitra bisnis','color'=>'#10b981'],
                ['icon'=>'fas fa-globe','title'=>'Orientasi Global','desc'=>'Berwawasan internasional dengan standar layanan kelas dunia','color'=>'#8b5cf6'],
            ];
            foreach ($values as $i => $val):
            ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?= $i * 80 ?>">
                <div style="background:#fff;border-radius:20px;padding:36px 24px;border:1px solid var(--border);transition:all 0.3s;height:100%;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 20px 50px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                    <div style="width:64px;height:64px;background:<?= $val['color'] ?>1a;border-radius:18px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                        <i class="<?= $val['icon'] ?> fa-lg" style="color:<?= $val['color'] ?>"></i>
                    </div>
                    <h5 style="font-weight:700;color:var(--primary);margin-bottom:10px;"><?= $val['title'] ?></h5>
                    <p style="color:var(--gray);font-size:0.88rem;line-height:1.7;margin:0;"><?= $val['desc'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?= $this->include('frontend/layout/footer') ?>
