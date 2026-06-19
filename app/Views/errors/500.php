<?php ob_start(); ?>

<div style="max-width: 650px; margin: 60px auto;">
    <h1 style="font-size: 2.5rem; color: var(--text-main); margin-bottom: 8px;">Something went wrong</h1>
    <p style="color: var(--text-muted); margin-bottom: 32px;">
        Production mode không hiển thị SQLSTATE hoặc đường dẫn file cho người dùng.
    </p>

    <div class="card" style="background: #fef2f2; border-color: #fecaca; margin-bottom: 24px;">
        <h3 style="color: #991b1b; margin-top: 0; font-size: 1.25rem;">Sorry, we could not load data right now.</h3>
        <p style="color: #991b1b; margin-bottom: 0;">Please try again later or contact the administrator.</p>
    </div>

    <div class="card" style="background: #f8fafc;">
        <h4 style="margin-top: 0; margin-bottom: 8px;">Developer note:</h4>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0;">
            Chi tiết lỗi đã được ghi vào file log của hệ thống; giao diện chỉ hiển thị safe message để bảo mật thông tin.
        </p>
    </div>

    <div style="margin-top: 32px;">
        <a href="/" class="btn primary">Quay lại Trang Chủ</a>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = '500 - Lỗi Hệ Thống';
require __DIR__ . '/../layout.php';
?>