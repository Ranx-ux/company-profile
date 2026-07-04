<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            background: #0a1628;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(59,130,246,0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -200px; left: -200px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(245,158,11,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .login-wrapper { width: 100%; max-width: 440px; padding: 20px; position: relative; z-index: 1; }
        .login-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 44px 40px;
            backdrop-filter: blur(20px);
        }
        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }
        .form-label { color: rgba(255,255,255,0.7); font-size: 0.82rem; font-weight: 600; letter-spacing: 0.3px; }
        .form-control {
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: #fff;
            padding: 13px 16px;
            font-size: 0.9rem;
            transition: all 0.25s;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.08);
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245,158,11,0.15);
            color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.3); }
        .input-group-text {
            background: rgba(255,255,255,0.06);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: rgba(255,255,255,0.4);
        }
        .input-group .form-control { border-left: none; border-radius: 0 12px 12px 0; }
        .btn-login {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 700;
            font-size: 0.95rem;
            color: #fff;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(245,158,11,0.4); color: #fff; }
        .divider { border-color: rgba(255,255,255,0.08); }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <!-- Brand -->
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i class="fas fa-building text-white fa-lg"></i>
            </div>
            <h4 style="color:#fff;font-weight:800;margin-bottom:4px;">Admin Panel</h4>
            <p style="color:rgba(255,255,255,0.45);font-size:0.85rem;margin:0;">PT Jaya Makmur — Company Profile</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert d-flex align-items-center gap-2 mb-4" style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);border-radius:12px;color:#fca5a5;font-size:0.88rem;">
            <i class="fas fa-exclamation-circle"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/login') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label mb-2">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope fa-sm"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="admin@jayamakmur.co.id" required autofocus>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label mb-2">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock fa-sm"></i></span>
                    <input type="password" name="password" id="pwdInput" class="form-control" placeholder="••••••••" required>
                    <button type="button" class="btn" style="background:rgba(255,255,255,0.06);border:1.5px solid rgba(255,255,255,0.1);border-left:none;border-radius:0 12px 12px 0;color:rgba(255,255,255,0.4);" onclick="togglePwd()">
                        <i class="fas fa-eye fa-sm" id="eyeIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Dashboard
            </button>
        </form>

        <hr class="divider my-4">
        <div class="text-center">
            <a href="<?= base_url() ?>" style="color:rgba(255,255,255,0.4);font-size:0.82rem;text-decoration:none;transition:color 0.2s;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='rgba(255,255,255,0.4)'">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Website
            </a>
        </div>
    </div>
    <p class="text-center mt-4" style="color:rgba(255,255,255,0.2);font-size:0.78rem;">&copy; <?= date('Y') ?> PT Jaya Makmur. All rights reserved.</p>
</div>

<script>
function togglePwd() {
    const input = document.getElementById('pwdInput');
    const icon = document.getElementById('eyeIcon');
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('fa-eye');
    icon.classList.toggle('fa-eye-slash');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
