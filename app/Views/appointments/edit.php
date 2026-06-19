<?php ob_start(); ?>

<h1>Edit Appointment</h1>

<form method="post" action="/appointments/update" class="card form-card">

    <input
        type="hidden"
        name="id"
        value="<?= e($id) ?>"
    >

    <label>Appointment Code</label>

    <input
        type="text"
        name="appointment_code"
        value="<?= e($old['appointment_code'] ?? '') ?>"
    >

    <?php if (!empty($errors['appointment_code'])): ?>
        <p class="error"><?= e($errors['appointment_code']) ?></p>
    <?php endif; ?>



    <label>Patient Name</label>

    <input
        type="text"
        name="patient_name"
        value="<?= e($old['patient_name'] ?? '') ?>"
    >

    <?php if (!empty($errors['patient_name'])): ?>
        <p class="error"><?= e($errors['patient_name']) ?></p>
    <?php endif; ?>



    <label>Patient Email</label>

    <input
        type="email"
        name="patient_email"
        value="<?= e($old['patient_email'] ?? '') ?>"
    >

    <?php if (!empty($errors['patient_email'])): ?>
        <p class="error"><?= e($errors['patient_email']) ?></p>
    <?php endif; ?>



    <label>Appointment Date</label>

    <input
        type="datetime-local"
        name="appointment_date"
        value="<?= e($old['appointment_date'] ?? '') ?>"
    >

    <?php if (!empty($errors['appointment_date'])): ?>
        <p class="error"><?= e($errors['appointment_date']) ?></p>
    <?php endif; ?>



    <label>Status</label>

    <select name="status">

        <?php foreach (['Scheduled','Completed','Cancelled'] as $status): ?>

            <option
                value="<?= e($status) ?>"
                <?= ($old['status'] ?? 'Scheduled') === $status ? 'selected' : '' ?>
            >
                <?= e($status) ?>
            </option>

        <?php endforeach; ?>

    </select>



    <label>Note</label>

    <textarea name="note"><?= e($old['note'] ?? '') ?></textarea>



    <button class="btn primary" type="submit">
        Update Appointment
    </button>

    <a class="btn" href="/appointments">
        Back
    </a>

</form>

<?php
$content = ob_get_clean();
$title = 'Edit Appointment';

require __DIR__ . '/../layout.php';