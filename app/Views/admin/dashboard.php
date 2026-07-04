<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<!-- Stats Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-primary">
            <div class="inner">
                <h3><?= $total_products ?></h3>
                <p>Total Produk</p>
            </div>
            <div class="icon"><i class="fas fa-box"></i></div>
            <a href="<?= base_url('admin/products') ?>" class="small-box-footer">Kelola <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3><?= $total_orders ?></h3>
                <p>Total Order</p>
            </div>
            <div class="icon"><i class="fas fa-shopping-bag"></i></div>
            <a href="<?= base_url('admin/orders') ?>" class="small-box-footer">Kelola <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3><?= $total_customers ?></h3>
                <p>Total Customer</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="<?= base_url('admin/customers') ?>" class="small-box-footer">Kelola <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-danger">
            <div class="inner">
                <h3>Rp <?= number_format($total_revenue, 0, ',', '.') ?></h3>
                <p>Total Pendapatan</p>
            </div>
            <div class="icon"><i class="fas fa-coins"></i></div>
            <a href="<?= base_url('admin/orders') ?>" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Info Row -->
<div class="row">
    <!-- Profile Info -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
                <h3 class="card-title text-white"><i class="fas fa-building me-2"></i>Profil Perusahaan</h3>
                <div class="card-tools">
                    <a href="<?= base_url('admin/profile') ?>" class="btn btn-sm btn-light"><i class="fas fa-edit me-1"></i>Edit</a>
                </div>
            </div>
            <div class="card-body">
                <?php if ($profile): ?>
                <table class="table table-sm table-borderless">
                    <tr>
                        <td width="35%" class="text-muted fw-semibold">Nama Perusahaan</td>
                        <td><?= esc($profile['nama_perusahaan'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Email</td>
                        <td><?= esc($profile['email'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Telepon</td>
                        <td><?= esc($profile['telepon'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Alamat</td>
                        <td><?= esc($profile['alamat'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Website</td>
                        <td><?= esc($profile['website'] ?? '-') ?></td>
                    </tr>
                </table>
                <?php else: ?>
                <div class="text-center py-3">
                    <i class="fas fa-exclamation-triangle text-warning fa-2x mb-2"></i>
                    <p class="text-muted">Profil perusahaan belum diisi.</p>
                    <a href="<?= base_url('admin/profile') ?>" class="btn btn-primary btn-sm">Isi Sekarang</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header" style="background:linear-gradient(135deg,#1a3c6e,#2d6a9f)">
                <h3 class="card-title text-white"><i class="fas fa-bolt me-2"></i>Aksi Cepat</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="<?= base_url('admin/products/create') ?>" class="btn btn-outline-primary w-100 py-3">
                            <i class="fas fa-plus-circle fa-lg d-block mb-2"></i>
                            Tambah Produk
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-outline-success w-100 py-3">
                            <i class="fas fa-tag fa-lg d-block mb-2"></i>
                            Tambah Kategori
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url('admin/users/create') ?>" class="btn btn-outline-warning w-100 py-3">
                            <i class="fas fa-user-plus fa-lg d-block mb-2"></i>
                            Tambah Admin
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= base_url() ?>" target="_blank" class="btn btn-outline-info w-100 py-3">
                            <i class="fas fa-eye fa-lg d-block mb-2"></i>
                            Lihat Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
