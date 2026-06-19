<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h1>Quản lý Lịch hẹn</h1>
    <a class="btn primary" href="/appointments/create">+ Tạo Lịch hẹn</a>
</div>

<form method="get" action="/appointments" class="toolbar">
    <input type="hidden" name="page" value="1">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="🔍 Tìm mã lịch hẹn, tên, email bệnh nhân..." style="flex: 1;">
    <input type="hidden" name="sort" value="<?= e($sort) ?>">
    <input type="hidden" name="direction" value="<?= e($direction) ?>">
    <button type="submit" class="btn secondary">Lọc dữ liệu</button>
</form>

<div class="card" style="padding: 0; overflow: hidden;">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th><a href="/appointments?<?= e(query_string(['sort' => 'appointment_code'])) ?>" style="color: inherit;">Mã lịch hẹn ↕</a></th>
                <th>Tên bệnh nhân</th>
                <th>Email</th>
                <th>Ngày hẹn khám</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appt): ?>
            <tr>
                <td style="color: var(--text-muted);">#<?= e($appt['id']) ?></td>
                <td style="font-weight: 600; color: var(--primary);"><?= e($appt['appointment_code']) ?></td>
                <td style="font-weight: 500;"><?= e($appt['patient_name']) ?></td>
                <td><?= e($appt['patient_email']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($appt['appointment_date'])) ?></td>
                <td>
                    <?php $s = strtolower(trim($appt['status'] ?? 'pending')); ?>
                    <span class="badge <?= e($s) ?>">
                        <?= e(($s === 'pending' || $s === 'scheduled') ? 'Đã lên lịch' : ($s === 'completed' ? 'Đã hoàn thành' : 'Đã hủy')) ?>
                    </span>
                </td>
                <td style="display: flex; gap: 12px; align-items: center;">
                    <a href="/appointments/edit?id=<?= e($appt['id']) ?>" style="color: var(--primary); text-decoration: none; font-weight: 500;">Sửa</a>
                    <form method="post" action="/appointments/delete" style="margin:0;" onsubmit="return confirm('Bạn có chắc chắn muốn hủy lịch hẹn này?')">
                        <input type="hidden" name="id" value="<?= e($appt['id']) ?>">
                        <button type="submit" class="link danger" style="border:none; cursor:pointer;">Xóa</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($appointments)): ?>
                <tr><td colspan="7" style="text-align: center; padding: 32px; color: var(--text-muted);">Không tìm thấy lịch hẹn nào</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="pagination">
    <span style="margin-right: auto; color: var(--text-muted); font-size: 0.9rem;">
        Trang <?= e($page) ?> / <?= e($totalPages ?: 1) ?> (Tổng: <?= e($total) ?> lịch hẹn)
    </span>
    <?php if ($page > 1): ?>
        <a href="/appointments?<?= e(query_string(['page' => $page - 1])) ?>">« Trang trước</a>
    <?php endif; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/appointments?<?= e(query_string(['page' => $page + 1])) ?>">Trang sau »</a>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Quản lý Lịch hẹn';
require __DIR__ . '/../layout.php';
?>