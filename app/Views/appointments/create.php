<?php ob_start(); ?>

<h1>Tạo Lịch hẹn khám mới</h1>
<p style="color: var(--text-muted); margin-bottom: 24px;">Form này submit bằng phương thức POST /appointments/store. Trùng mã đơn/mã lịch hẹn sẽ kích hoạt hệ thống chặn.</p>

<div style="display: flex; gap: 24px; align-items: flex-start;">
    <form method="post" action="/appointments/store" class="card form-card" style="flex: 1; margin: 0;">
        <div>
            <label>Mã lịch hẹn *</label>
            <input type="text" name="appointment_code" value="<?= e($old['appointment_code'] ?? '') ?>" placeholder="VD: LH-2026-0001">
            <?php if (!empty($errors['appointment_code'])): ?><p class="error">⚠️ <?= e($errors['appointment_code']) ?></p><?php endif; ?>
        </div>

        <div>
            <label>Tên bệnh nhân *</label>
            <input type="text" name="patient_name" value="<?= e($old['patient_name'] ?? '') ?>" placeholder="Nhập tên bệnh nhân">
            <?php if (!empty($errors['patient_name'])): ?><p class="error"><?= e($errors['patient_name']) ?></p><?php endif; ?>
        </div>

        <div>
            <label>Email bệnh nhân</label>
            <input type="email" name="patient_email" value="<?= e($old['patient_email'] ?? '') ?>" placeholder="VD: benhnhan@example.com">
            <?php if (!empty($errors['patient_email'])): ?><p class="error"><?= e($errors['patient_email']) ?></p><?php endif; ?>
        </div>

        <div>
            <label>Ngày & Giờ hẹn khám *</label>
            <input type="datetime-local" name="appointment_date" value="<?= e($old['appointment_date'] ?? '') ?>">
            <?php if (!empty($errors['appointment_date'])): ?><p class="error"><?= e($errors['appointment_date']) ?></p><?php endif; ?>
        </div>

        <div>
            <label>Trạng thái ban đầu</label>
            <select name="status">
                <option value="Pending" <?= ($old['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Chờ khám (Pending)</option>
                <option value="Completed" <?= ($old['status'] ?? '') === 'Completed' ? 'selected' : '' ?>>Đã hoàn thành (Completed)</option>
                <option value="Cancelled" <?= ($old['status'] ?? '') === 'Cancelled' ? 'selected' : '' ?>>Đã hủy (Cancelled)</option>
            </select>
        </div>

        <div>
            <label>Ghi chú triệu chứng bệnh</label>
            <textarea name="note" rows="3" placeholder="Nhập tình trạng bệnh lý sơ bộ..."><?= e($old['note'] ?? '') ?></textarea>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 16px;">
            <button class="btn primary" type="submit">Save Order</button>
            <a class="btn secondary" href="/appointments">Back</a>
        </div>
    </form>

    <div class="card" style="width: 320px; background: #f8fafc;">
        <h3 style="margin-top:0;">Database rule</h3>
        <p style="font-weight: 700; color: #b45309; margin-bottom: 8px;">UNIQUE KEY</p>
        <p style="font-family: monospace; background: #e2e8f0; padding: 6px; border-radius: 4px; font-size: 0.9rem; margin-top:0;">unique_order_code</p>
        <p style="color: var(--text-muted); font-size: 0.9rem; line-height: 1.6;">
            Tầng PHP có thể kiểm tra trước, nhưng database là lớp bảo vệ cuối cùng. Khi trùng mã, constraint sẽ chặn lại và xuất friendly error.
        </p>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Tạo Lịch hẹn';
require __DIR__ . '/../layout.php';
?>