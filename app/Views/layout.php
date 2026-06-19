
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Clinic DB App') ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <nav class="navbar">
        <a href="/" class="brand">🏥 Clinic App</a>
        <a href="/patients">Bệnh nhân</a>
        <a href="/patients/create">+ Thêm Bệnh nhân</a>
        <a href="/appointments">Lịch hẹn</a>
        <a href="/appointments/create">+ Tạo Lịch hẹn</a>
        <a href="/health">Health Check</a>
    </nav>
    <main class="container">
        <?php if ($success = flash_get('success')): ?>
            <div class="alert success">✅ <?= e($success) ?></div>
        <?php endif; ?>
        
        <?= $content ?? '' ?>
    </main>
</body>
</html>