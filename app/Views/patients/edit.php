<?php ob_start(); ?>

<h1>Sửa thông tin Bệnh nhân</h1>
<p style="color: var(--text-muted); margin-bottom: 24px;">Cập nhật thông tin chi tiết và trạng thái của bệnh nhân. Form này gọi POST /patients/update.</p>

<div style="display: flex; gap: 24px; align-items: flex-start;">
    <form method="post" action="/patients/update" class="card form-card" style="flex: 1; margin: 0;">
        <input type="hidden" name="id" value="<?= e($id) ?>">
        
        <div>
            <label>Họ và tên *</label>
            <input type="text" name="name" value="<?= e($old['name'] ?? '') ?>" placeholder="Nhập họ tên bệnh nhân">
            <?php if (!empty($errors['name'])): ?><p class="error"><?= e($errors['name']) ?></p><?php endif; ?>
        </div>
        
        <div>
            <label>Email liên hệ *</label>
            <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>" placeholder="VD: email@example.com">
            <?php if (!empty($errors['email'])): ?><p class="error">⚠️ <?= e($errors['email']) ?></p><?php endif; ?>
        </div>

        <div>
            <label>Số điện thoại</label>
            <input type="text" name="phone" value="<?= e($old['phone'] ?? '') ?>" placeholder="Nhập số điện thoại">
        </div>

        <div>
            <label>Giới tính</label>
            <select name="gender">
                <?php $g = strtolower(trim($old['gender'] ?? '')); ?>
                <option value="Male" <?= $g === 'male' ? 'selected' : '' ?>>Nam</option>
                <option value="Female" <?= $g === 'female' ? 'selected' : '' ?>>Nữ</option>
                <option value="Other" <?= $g === 'other' ? 'selected' : '' ?>>Khác</option>
            </select>
            <?php if (!empty($errors['gender'])): ?><p class="error"><?= e($errors['gender']) ?></p><?php endif; ?>
        </div>

        <div>
            <label>Trạng thái bệnh nhân</label>
            <select name="status">
                <?php 
                    $s = strtolower(trim($old['status'] ?? 'new'));
                    foreach (['new' => 'Mới (New)', 'contacted' => 'Đã liên hệ (Contacted)', 'qualified' => 'Đạt yêu cầu (Qualified)', 'lost' => 'Đã hủy (Lost)'] as $val => $label): 
                ?>
                    <option value="<?= e($val) ?>" <?= $s === $val ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['status'])): ?><p class="error"><?= e($errors['status']) ?></p><?php endif; ?>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 16px;">
            <button class="btn primary" type="submit">Cập nhật thông tin</button>
            <a class="btn secondary" href="/patients">Hủy / Quay lại</a>
        </div>
    </form>

    <div class="card" style="width: 320px; background: #f8fafc;">
        <h3 style="margin-top:0;">Lưu ý cập nhật</h3>
        <ul style="color: var(--text-muted); padding-left: 20px; line-height: 2; font-size: 0.95rem;">
            <li>🔹 ID bệnh nhân không thể thay đổi</li>
            <li>🔹 Cập nhật Trạng thái tùy theo tiến độ chăm sóc</li>
            <li>🔹 Vẫn bắt lỗi trùng Email (Duplicate Unique Key) nếu bạn nhập email của người khác</li>
            <li>🔹 Redirect về trang danh sách nếu thành công</li>
        </ul>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Sửa Bệnh nhân';
require __DIR__ . '/../layout.php';
?>