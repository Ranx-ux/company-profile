<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up">Login</h1>
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Login Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7" data-aos="fade-up">
                <div style="background:#fff;border-radius:24px;padding:40px;border:1px solid var(--border);box-shadow:0 4px 30px rgba(0,0,0,0.06);">
                    <div class="text-center mb-4">
                        <div style="width:64px;height:64px;background:linear-gradient(135deg,var(--secondary),#fbbf24);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                            <i class="fas fa-user-circle fa-2x text-white"></i>
                        </div>
                        <h4 style="font-weight:800;color:var(--primary);margin-bottom:4px;">Masuk Akun</h4>
                        <p style="color:var(--gray);font-size:0.88rem;margin:0;">Login untuk melanjutkan checkout & pembayaran</p>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" style="border-radius:12px;font-size:0.88rem;">
                        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger" style="border-radius:12px;font-size:0.88rem;">
                        <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('info')): ?>
                    <div class="alert alert-info" style="border-radius:12px;font-size:0.88rem;">
                        <i class="fas fa-info-circle me-2"></i><?= session()->getFlashdata('info') ?>
                    </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger" style="border-radius:12px;font-size:0.88rem;">
                        <?php foreach (session()->getFlashdata('errors') as $err): ?>
                            <div><i class="fas fa-times-circle me-2"></i><?= esc($err) ?></div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Google OAuth Login Button -->
                    <a href="<?= base_url('auth/google') ?>" class="btn w-100 d-flex align-items-center justify-content-center gap-3" style="background:#fff;border:2px solid #dadce0;color:#3c4043;font-weight:600;padding:14px;border-radius:12px;font-size:0.95rem;transition:all 0.3s;text-decoration:none;" onmouseover="this.style.background='#f7f8f8';this.style.borderColor='#c6c8ca'" onmouseout="this.style.background='#fff';this.style.borderColor='#dadce0'">
                        <svg width="20" height="20" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
                        Masuk dengan Google
                    </a>

                    <hr class="my-4">

                    <!-- Email + Password Login (Fallback) -->
                    <form action="<?= base_url('auth/login') ?>" method="POST">
                        <?= csrf_field() ?>
                        <p class="text-center mb-3" style="color:var(--gray);font-size:0.8rem;font-weight:600;">Atau login dengan email</p>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" style="background:#f8fafc;border:1.5px solid var(--border);border-right:none;border-radius:10px 0 0 10px;color:var(--gray);">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" style="border:1.5px solid var(--border);border-left:none;border-radius:0 10px 10px 0;padding:12px 16px;" placeholder="Email" value="<?= old('email') ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text" style="background:#f8fafc;border:1.5px solid var(--border);border-right:none;border-radius:10px 0 0 10px;color:var(--gray);">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" id="pwdInput" class="form-control" style="border:1.5px solid var(--border);border-left:none;border-radius:0 10px 10px 0;padding:12px 16px;" placeholder="Password" required>
                                <button type="button" class="btn" style="background:#f8fafc;border:1.5px solid var(--border);border-left:none;border-radius:0 10px 10px 0;color:var(--gray);" onclick="togglePwd()">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn w-100" style="background:var(--secondary);color:#fff;font-weight:700;padding:13px;border-radius:10px;font-size:0.95rem;transition:all 0.3s;">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function togglePwd() {
    const input = document.getElementById('pwdInput');
    const icon = document.getElementById('eyeIcon');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}
</script>

<?= $this->include('frontend/layout/footer') ?>
<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-white fw-bold" data-aos="fade-up">Login Customer</h1>
                <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                        <li class="breadcrumb-item active">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Login Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7" data-aos="fade-up">
                <div style="background:#fff;border-radius:24px;padding:40px;border:1px solid var(--border);box-shadow:0 4px 30px rgba(0,0,0,0.06);">
                    <div class="text-center mb-4">
                        <div style="width:64px;height:64px;background:linear-gradient(135deg,var(--secondary),#fbbf24);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                            <i class="fas fa-user-circle fa-2x text-white"></i>
                        </div>
                        <h4 style="font-weight:800;color:var(--primary);margin-bottom:4px;">Masuk Akun</h4>
                        <p style="color:var(--gray);font-size:0.88rem;margin:0;">Login untuk melanjutkan checkout & pembayaran</p>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success" style="border-radius:12px;font-size:0.88rem;">
                        <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    </div>
                    <?php endif; ?>

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

                    <?php if (session()->getFlashdata('info')): ?>
                    <div class="alert alert-info" style="border-radius:12px;font-size:0.88rem;">
                        <i class="fas fa-info-circle me-2"></i><?= session()->getFlashdata('info') ?>
                    </div>
                    <?php endif; ?>

                    <form action="<?= base_url('auth/login') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Email</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#f8fafc;border:1.5px solid var(--border);border-right:none;border-radius:10px 0 0 10px;color:var(--gray);">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" name="email" class="form-control" style="border:1.5px solid var(--border);border-left:none;border-radius:0 10px 10px 0;padding:12px 16px;" placeholder="email@contoh.com" value="<?= old('email') ?>" required autofocus>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" style="font-weight:600;font-size:0.85rem;color:var(--primary);">Password</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background:#f8fafc;border:1.5px solid var(--border);border-right:none;border-radius:10px 0 0 10px;color:var(--gray);">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" name="password" id="pwdInput" class="form-control" style="border:1.5px solid var(--border);border-left:none;border-radius:0 10px 10px 0;padding:12px 16px;" placeholder="Min. 6 karakter" required>
                                <button type="button" class="btn" style="background:#f8fafc;border:1.5px solid var(--border);border-left:none;border-radius:0 10px 10px 0;color:var(--gray);" onclick="togglePwd()">
                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn w-100" style="background:var(--secondary);color:#fff;font-weight:700;padding:13px;border-radius:10px;font-size:0.95rem;transition:all 0.3s;">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p style="color:var(--gray);font-size:0.88rem;margin:0;">
                            Belum punya akun?
                            <a href="<?= base_url('auth/register') ?>" style="color:var(--secondary);font-weight:700;text-decoration:none;">Daftar Sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function togglePwd() {
    const input = document.getElementById('pwdInput');
    const icon = document.getElementById('eyeIcon');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}
</script>

<?= $this->include('frontend/layout/footer') ?>
