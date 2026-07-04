<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up">Daftar Akun</h1>
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Daftar</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Register Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7" data-aos="fade-up">
                <div style="background:#fff;border-radius:24px;padding:40px;border:1px solid var(--border);box-shadow:0 4px 30px rgba(0,0,0,0.06);">
                    <div class="text-center mb-4">
                        <div style="width:64px;height:64px;background:linear-gradient(135deg,var(--secondary),#fbbf24);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                            <i class="fas fa-user-plus fa-2x text-white"></i>
                        </div>
                        <h4 style="font-weight:800;color:var(--primary);margin-bottom:4px;">Buat Akun Baru</h4>
                        <p style="color:var(--gray);font-size:0.88rem;margin:0;">Daftar untuk mulai belanja dan checkout</p>
                    </div>

                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" style="border-radius:12px;font-size:0.88rem;">
                        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger" style="border-radius:12px;font-size:0.88rem;">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <div><i class="fas fa-times-circle me-2"></i><?= esc($err) ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/register') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" style="border:1.5px solid var(--border);border-radius:10px;padding:12px 16px;" placeholder="Nama Anda" value="<?= old('nama') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Email</label>
                            <input type="email" name="email" class="form-control" style="border:1.5px solid var(--border);border-radius:10px;padding:12px 16px;" placeholder="email@contoh.com" value="<?= old('email') ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Password</label>
                            <input type="password" name="password" id="regPwd" class="form-control" style="border:1.5px solid var(--border);border-radius:10px;padding:12px 16px;" placeholder="Min. 6 karakter" required>
                        </div>
                        <button type="submit" class="btn w-100" style="background:var(--secondary);color:#fff;font-weight:700;padding:13px;border-radius:10px;font-size:0.95rem;transition:all 0.3s;">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p style="color:var(--gray);font-size:0.88rem;margin:0;">
                            Sudah punya akun?
                            <a href="<?= base_url('auth/login') ?>" style="color:var(--secondary);font-weight:700;text-decoration:none;">Login di sini</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('frontend/layout/footer') ?>
