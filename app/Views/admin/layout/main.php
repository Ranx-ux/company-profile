<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Dashboard') ?> | Admin Panel</title>
    <!-- AdminLTE 3.2.0 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body, .nav-sidebar .nav-link, .brand-text, .sidebar-dark-primary { font-family: 'Poppins', sans-serif !important; }
        .main-header { border-bottom: 2px solid #1a3c6e; }
        .brand-link { background: #1a3c6e !important; }
        .sidebar-dark-primary { background: #1a3c6e !important; }
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active { background: rgba(255,255,255,0.15) !important; }
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link:hover { background: rgba(255,255,255,0.1) !important; }
        .content-wrapper { background: #f4f6f9; }
        .card { border-radius: 12px; border: none; box-shadow: 0 2px 15px rgba(0,0,0,0.08); }
        .card-header { border-radius: 12px 12px 0 0 !important; }
        .btn { border-radius: 8px; font-weight: 500; }
        .table th { font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge { font-weight: 500; }
        .info-box { border-radius: 12px; }
        .small-box { border-radius: 12px; }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= base_url() ?>" target="_blank" class="nav-link"><i class="fas fa-external-link-alt me-1"></i>Lihat Website</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-user-circle fa-lg me-1"></i>
                    <?= esc(session()->get('admin_nama')) ?>
                    <i class="fas fa-chevron-down ms-1 small"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <span class="dropdown-item-text">
                        <small class="text-muted"><?= esc(session()->get('admin_email')) ?></small><br>
                        <span class="badge badge-primary"><?= esc(session()->get('admin_role')) ?></span>
                    </span>
                    <div class="dropdown-divider"></div>
                    <a href="<?= base_url('admin/logout') ?>" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="<?= base_url('admin/dashboard') ?>" class="brand-link">
            <i class="fas fa-building brand-image img-circle elevation-3 p-1 ms-2" style="font-size:1.5rem;color:#e8a020;"></i>
            <span class="brand-text font-weight-bold" style="color:#fff">Jaya Makmur</span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <?php if (session()->get('admin_foto')): ?>
                        <img src="<?= base_url('uploads/users/' . session()->get('admin_foto')) ?>" class="img-circle elevation-2" alt="User Image" style="width:35px;height:35px;object-fit:cover;">
                    <?php else: ?>
                        <i class="fas fa-user-circle fa-2x text-white ms-1"></i>
                    <?php endif; ?>
                </div>
                <div class="info">
                    <a href="#" class="d-block text-white"><?= esc(session()->get('admin_nama')) ?></a>
                    <small class="text-white-50"><?= esc(session()->get('admin_role')) ?></small>
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-header" style="color:rgba(255,255,255,0.4)">MENU UTAMA</li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/dashboard')) !== false || current_url() == base_url('admin')) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header" style="color:rgba(255,255,255,0.4)">KELOLA KONTEN</li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/profile') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/profile')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Profil Perusahaan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/categories') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/categories')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Kategori</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/products') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/products')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Produk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/services') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/services')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Layanan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/gallery') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/gallery')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Galeri</p>
                        </a>
                    </li>
                    <li class="nav-header" style="color:rgba(255,255,255,0.4)">E-COMMERCE</li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/orders') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/orders')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>Pesanan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/customers') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/customers')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Customer</p>
                        </a>
                    </li>
                    <li class="nav-header" style="color:rgba(255,255,255,0.4)">PENGATURAN</li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/users') ?>" class="nav-link <?= (strpos(current_url(), base_url('admin/users')) !== false) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>User Admin</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('admin/logout') ?>" class="nav-link text-danger">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0" style="font-size:1.4rem;font-weight:600"><?= esc($title ?? 'Dashboard') ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?= esc($title ?? 'Dashboard') ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="container-fluid">

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php foreach (session()->getFlashdata('errors') as $err): ?>
                        <div><i class="fas fa-times-circle me-2"></i><?= esc($err) ?></div>
                    <?php endforeach; ?>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>&copy; <?= date('Y') ?> PT Jaya Makmur.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
