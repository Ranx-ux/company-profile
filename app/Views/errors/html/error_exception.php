<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - <?= esc($title ?? 'Application Error') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * { font-family: 'Segoe UI', sans-serif; }
        body { background: #f4f6f9; }
        .error-card { border-radius: 15px; border-left: 5px solid #dc3545; }
        pre { background: #2d2d2d; color: #f8f8f2; padding: 20px; border-radius: 10px; font-size: 0.85rem; overflow-x: auto; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="card shadow error-card p-4">
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-bug fa-2x text-danger me-3"></i>
            <div>
                <h4 class="mb-0 text-danger"><?= esc($title ?? 'Application Error') ?></h4>
                <small class="text-muted">CodeIgniter 4 - PT Jaya Makmur</small>
            </div>
        </div>
        <?php if (isset($message)): ?>
        <div class="alert alert-danger">
            <strong>Pesan:</strong> <?= esc($message) ?>
        </div>
        <?php endif; ?>
        <?php if (ENVIRONMENT !== 'production' && isset($exception)): ?>
        <h6 class="mt-3">Stack Trace:</h6>
        <pre><?= esc($exception->getTraceAsString()) ?></pre>
        <?php endif; ?>
        <a href="/" class="btn btn-primary mt-3">
            <i class="fas fa-home me-2"></i>Kembali ke Beranda
        </a>
    </div>
</div>
</body>
</html>
