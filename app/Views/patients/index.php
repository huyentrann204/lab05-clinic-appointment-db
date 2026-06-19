<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Quản lý Bệnh nhân</h1>
    <a class="btn primary" href="/patients/create">+ Thêm Bệnh nhân</a>
</div>

<form method="get" action="/patients" class="toolbar">
    <input type="hidden" name="page" value="1">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Tìm tên, email, sđt..." style="flex: 1;">
    <input type="hidden" name="sort" value="<?= e($sort) ?>">
    <input type="hidden" name="direction" value="<?= e($direction) ?>">
    <button type="submit" class="btn secondary">Lọc dữ liệu</button>
</form>

<div class="card" style="padding: 0; overflow: hidden;">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th><a href="/patients?<?= e(query_string(['sort' => 'name'])) ?>" style="color: inherit;">Họ tên ↕</a></th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Giới tính</th>
                <th>Trạng thái</th>
                <th><a href="/patients?<?= e(query_string(['sort' => 'created_at'])) ?>" style="color: inherit;">Ngày tạo ↕</a></th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient): ?>
            <tr>
                <td style="color: var(--text-muted);">#<?= e($patient['id']) ?></td>
                <td style="font-weight: 500;"><?= e($patient['name']) ?></td>
                <td><?= e($patient['email']) ?></td>
                <td><?= e($patient['phone']) ?></td>
                <td>
                    <?php 
                        // Ép dữ liệu DB về chữ thường hoàn toàn
                        $g = strtolower(trim($patient['gender'] ?? 'other')); 
                    ?>
                    <span class="badge <?= e($g) ?>">
                        <?= e($g === 'male' ? 'Nam' : ($g === 'female' ? 'Nữ' : 'Khác')) ?>
                    </span>
                </td>
                <td>
                    <span class="badge <?= e($patient['status']) ?>">
                        <?= e($patient['status'] === 'new' ? 'Mới' : ($patient['status'] === 'contacted' ? 'Đã liên hệ' : ($patient['status'] === 'qualified' ? 'Đạt yêu cầu' : 'Đã hủy'))) ?>
                    </span>
                </td>
                <td><?= date('d/m/Y', strtotime($patient['created_at'])) ?></td>
                <td style="display: flex; gap: 12px; align-items: center;">
                    <a href="/patients/edit?id=<?= e($patient['id']) ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">Sửa</a>
                    <form method="post" action="/patients/delete" style="margin:0;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bệnh nhân này?')">
                        <input type="hidden" name="id" value="<?= e($patient['id']) ?>">
                        <button type="submit" class="link danger" style="border:none; cursor:pointer;">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="pagination">
    <span style="margin-right: auto; color: var(--text-muted); font-size: 0.9rem;">
        Trang <?= e($page) ?> / <?= e($totalPages ?: 1) ?> (Tổng: <?= e($total) ?> bản ghi)
    </span>
    <?php if ($page > 1): ?>
        <a href="/patients?<?= e(query_string(['page' => $page - 1])) ?>">« Trang trước</a>
    <?php endif; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/patients?<?= e(query_string(['page' => $page + 1])) ?>">Trang sau »</a>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Quản lý Bệnh nhân';
require __DIR__ . '/../layout.php';
?>