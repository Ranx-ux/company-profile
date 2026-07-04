<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Beranda') ?> — <?= esc($profile['nama_perusahaan'] ?? 'PT Jaya Makmur') ?></title>
    <meta name="description" content="<?= esc(substr($profile['deskripsi'] ?? '', 0, 160)) ?>">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            --primary:   #0f2d5e;
            --primary-light: #1a4a8a;
            --secondary: #f59e0b;
            --accent:    #3b82f6;
            --dark:      #0a1628;
            --light:     #f8fafc;
            --gray:      #64748b;
            --border:    #e2e8f0;
        }
        * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { overflow-x: hidden; color: #1e293b; }

        /* ── NAVBAR ── */
        .navbar {
            background: rgba(10, 22, 40, 0.97) !important;
            backdrop-filter: blur(20px);
            padding: 14px 0;
            transition: all 0.3s;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .navbar.scrolled { padding: 10px 0; box-shadow: 0 4px 30px rgba(0,0,0,0.3); }
        .navbar-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: #fff !important;
            letter-spacing: -0.3px;
        }
        .navbar-brand .brand-dot { color: var(--secondary); }
        .nav-link {
            color: rgba(255,255,255,0.75) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: all 0.25s;
            letter-spacing: 0.2px;
        }
        .nav-link:hover, .nav-link.active {
            color: #fff !important;
            background: rgba(255,255,255,0.1);
        }
        .nav-link.active { color: var(--secondary) !important; }
        .navbar-toggler { border: 1px solid rgba(255,255,255,0.2); padding: 6px 10px; }
        .navbar-toggler-icon { filter: invert(1); }
        .btn-nav-cta {
            background: var(--secondary);
            color: #fff !important;
            padding: 8px 20px !important;
            border-radius: 8px;
            font-weight: 600;
        }
        .btn-nav-cta:hover { background: #d97706; color: #fff !important; }

        /* ── HERO ── */
        .hero-section {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 60%, var(--primary-light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .hero-section .hero-bg-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(59,130,246,0.08);
        }
        .hero-section .shape-1 { width: 700px; height: 700px; top: -200px; right: -200px; }
        .hero-section .shape-2 { width: 400px; height: 400px; bottom: -150px; left: -100px; background: rgba(245,158,11,0.06); }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(245,158,11,0.15);
            border: 1px solid rgba(245,158,11,0.3);
            color: var(--secondary);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.82rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 24px;
        }
        .hero-title {
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            font-weight: 800;
            line-height: 1.15;
            color: #fff;
            letter-spacing: -1px;
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, var(--secondary), #fbbf24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-desc { color: rgba(255,255,255,0.7); font-size: 1.05rem; line-height: 1.8; }
        .btn-hero-primary {
            background: var(--secondary);
            color: #fff;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-hero-primary:hover { background: #d97706; color: #fff; transform: translateY(-2px); box-shadow: 0 8px 25px rgba(245,158,11,0.4); }
        .btn-hero-outline {
            background: transparent;
            color: #fff;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            border: 1.5px solid rgba(255,255,255,0.3);
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-hero-outline:hover { background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.6); }
        .hero-stat-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 20px;
            backdrop-filter: blur(10px);
            text-align: center;
        }
        .hero-stat-number { font-size: 2rem; font-weight: 800; color: var(--secondary); line-height: 1; }
        .hero-stat-label { color: rgba(255,255,255,0.65); font-size: 0.8rem; margin-top: 4px; }

        /* ── SECTIONS ── */
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eff6ff;
            color: var(--accent);
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }
        .section-title {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        .section-desc { color: var(--gray); font-size: 1rem; line-height: 1.7; }
        .divider-line {
            width: 50px;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary), #fbbf24);
            border-radius: 2px;
            margin: 12px 0 20px;
        }
        .divider-line.center { margin: 12px auto 20px; }

        /* ── SERVICE CARDS ── */
        .service-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 32px 28px;
            transition: all 0.35s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transform: scaleX(0);
            transition: transform 0.35s;
        }
        .service-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px rgba(15,45,94,0.12); border-color: transparent; }
        .service-card:hover::before { transform: scaleX(1); }
        .service-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
        }
        .service-icon i { font-size: 1.5rem; color: #fff; }
        .service-card h5 { font-weight: 700; font-size: 1.05rem; color: var(--primary); margin-bottom: 10px; }
        .service-card p { color: var(--gray); font-size: 0.88rem; line-height: 1.7; }
        .service-tag {
            display: inline-block;
            background: #eff6ff;
            color: var(--accent);
            padding: 3px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* ── GALLERY ── */
        .gallery-item { position: relative; overflow: hidden; border-radius: 16px; cursor: pointer; }
        .gallery-item img { width: 100%; height: 260px; object-fit: cover; transition: transform 0.5s; }
        .gallery-item:hover img { transform: scale(1.08); }
        .gallery-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(10,22,40,0.9) 0%, rgba(10,22,40,0.2) 60%, transparent 100%);
            display: flex; align-items: flex-end;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.35s;
        }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        .gallery-overlay-content { color: #fff; }
        .gallery-overlay-content p { font-weight: 600; font-size: 0.9rem; margin: 0; }
        .gallery-overlay-content span { font-size: 0.75rem; opacity: 0.75; }

        /* ── STATS SECTION ── */
        .stats-section { background: linear-gradient(135deg, var(--dark), var(--primary)); }
        .stat-box { text-align: center; padding: 40px 20px; }
        .stat-number { font-size: 3rem; font-weight: 800; color: var(--secondary); line-height: 1; }
        .stat-label { color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-top: 8px; }

        /* ── CTA ── */
        .cta-section { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }

        /* ── FOOTER ── */
        footer { background: var(--dark); color: rgba(255,255,255,0.75); }
        footer h6 { color: #fff; font-weight: 700; font-size: 0.95rem; margin-bottom: 16px; }
        footer a { color: rgba(255,255,255,0.6); text-decoration: none; font-size: 0.88rem; transition: color 0.2s; }
        footer a:hover { color: var(--secondary); }
        footer p { font-size: 0.88rem; }
        .footer-divider { border-color: rgba(255,255,255,0.08); }
        .social-btn {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.08);
            border-radius: 10px;
            display: inline-flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.7);
            transition: all 0.25s;
            text-decoration: none;
        }
        .social-btn:hover { background: var(--secondary); color: #fff; transform: translateY(-2px); }

        /* ── SCROLL TOP ── */
        #scrollTop {
            position: fixed; bottom: 28px; right: 28px;
            width: 44px; height: 44px;
            background: var(--secondary);
            color: #fff; border: none; border-radius: 12px;
            display: none; align-items: center; justify-content: center;
            cursor: pointer; z-index: 999;
            box-shadow: 0 4px 20px rgba(245,158,11,0.4);
            transition: all 0.3s;
        }
        #scrollTop:hover { transform: translateY(-3px); }

        /* ── BREADCRUMB ── */
        .page-header {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            padding: 90px 0 50px;
            position: relative;
            overflow: hidden;
        }
        .page-header::after {
            content: '';
            position: absolute;
            bottom: -1px; left: 0; right: 0;
            height: 60px;
            background: #fff;
            clip-path: ellipse(55% 100% at 50% 100%);
        }
        .page-header.bg-light-page::after { background: #f8fafc; }
        .breadcrumb-item a { color: var(--secondary); text-decoration: none; }
        .breadcrumb-item.active { color: rgba(255,255,255,0.7); }
        .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,0.4); }

        /* ── UTILITIES ── */
        .btn-primary-custom {
            background: var(--secondary); border: none; color: #fff;
            padding: 12px 28px; border-radius: 10px; font-weight: 700;
            transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary-custom:hover { background: #d97706; color: #fff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(245,158,11,0.35); }
        .btn-outline-custom {
            background: transparent; border: 2px solid rgba(255,255,255,0.3); color: #fff;
            padding: 12px 28px; border-radius: 10px; font-weight: 600;
            transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-outline-custom:hover { background: rgba(255,255,255,0.1); color: #fff; border-color: rgba(255,255,255,0.6); }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url() ?>">
            <?php if (!empty($profile['logo'])): ?>
                <img src="<?= base_url('uploads/logo/' . $profile['logo']) ?>" alt="Logo" height="36" style="border-radius:8px;">
            <?php else: ?>
                <div style="width:36px;height:36px;background:linear-gradient(135deg,var(--secondary),#fbbf24);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-building" style="color:#fff;font-size:1rem;"></i>
                </div>
            <?php endif; ?>
            <?= esc($profile['nama_perusahaan'] ?? 'PT Jaya Makmur') ?><span class="brand-dot">.</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item"><a class="nav-link <?= (current_url() == base_url()) || (current_url() == base_url('/')) ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a></li>
                <li class="nav-item"><a class="nav-link <?= (strpos(current_url(), base_url('about')) !== false) ? 'active' : '' ?>" href="<?= base_url('about') ?>">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link <?= (strpos(current_url(), base_url('services')) !== false) ? 'active' : '' ?>" href="<?= base_url('services') ?>">Layanan</a></li>
                <li class="nav-item"><a class="nav-link <?= (strpos(current_url(), base_url('products')) !== false) ? 'active' : '' ?>" href="<?= base_url('products') ?>">Produk</a></li>
                <li class="nav-item"><a class="nav-link <?= (strpos(current_url(), base_url('gallery')) !== false) ? 'active' : '' ?>" href="<?= base_url('gallery') ?>">Galeri</a></li>
                <li class="nav-item"><a class="nav-link <?= (strpos(current_url(), base_url('contact')) !== false) ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Kontak</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2 ms-2">
                <a href="<?= base_url('cart') ?>" class="nav-link position-relative" title="Keranjang">
                    <i class="fas fa-shopping-cart" style="color:rgba(255,255,255,0.75)"></i>
                    <span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:0.6rem;"><?php $cart = session()->get('cart'); echo $cart ? array_sum(array_column($cart, 'qty')) : 0; ?></span>
                </a>
                <?php if (session()->get('customer_logged_in')): ?>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?= esc(session()->get('customer_name')) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('auth/logout') ?>"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>" class="btn-nav-cta nav-link"><i class="fab fa-google me-1"></i> Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
window.addEventListener('scroll', () => {
    document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 50);
});
</script>
