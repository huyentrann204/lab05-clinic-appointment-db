<?php ob_start(); ?>

<h1>Thêm Bệnh nhân mới</h1>
<p style="color: var(--text-muted); margin-bottom: 24px;">Form này submit bằng phương thức POST /patients/store, nếu thành công sẽ redirect về /patients.</p>

<div style="display: flex; gap: 24px; align-items: flex-start;">
    <form method="post" action="/patients/store" class="card form-card" style="flex: 1; margin: 0;">
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
                <option value="Male" <?= ($old['gender'] ?? '') === 'Male' ? 'selected' : '' ?>>Nam</option>
                <option value="Female" <?= ($old['gender'] ?? '') === 'Female' ? 'selected' : '' ?>>Nữ</option>
                <option value="Other" <?= ($old['gender'] ?? 'Other') === 'Other' ? 'selected' : '' ?>>Khác</option>
            </select>
        </div>

        <div>
            <label>Trạng thái bệnh nhân</label>
            <select name="status">
                <?php foreach (['new' => 'Mới (New)', 'contacted' => 'Đã liên hệ (Contacted)', 'qualified' => 'Đạt yêu cầu (Qualified)', 'lost' => 'Đã hủy (Lost)'] as $val => $label): ?>
                    <option value="<?= e($val) ?>" <?= ($old['status'] ?? 'new') === $val ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 16px;">
            <button class="btn primary" type="submit">Save Patient</button>
            <a class="btn secondary" href="/patients">Back to Patients</a>
        </div>
    </form>

    <div class="card" style="width: 320px; background: #f8fafc;">
        <h3 style="margin-top:0;">Form requirements</h3>
        <ul style="color: var(--text-muted); padding-left: 20px; line-height: 2; font-size: 0.95rem;">
            <li>🔹 Validate required fields</li>
            <li>🔹 Email format</li>
            <li>🔹 Phone length/pattern</li>
            <li>🔹 Prepared statement INSERT</li>
            <li>🔹 Catch duplicate email</li>
            <li>🔹 PRG after success</li>
            <li>🔹 Keep old data when error</li>
        </ul>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Thêm Bệnh nhân';
require __DIR__ . '/../layout.php';
?>