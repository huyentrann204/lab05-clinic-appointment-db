<?php ob_start(); ?>

<div style="text-align: center; margin-bottom: 48px;">
    <h1 style="font-size: 2.2rem; margin-bottom: 8px;">Lab05 - Database CRUD Management App</h1>
    <p style="color: var(--text-muted); font-size: 1.1rem; margin-top: 0;">
        PDO + Repository + CRUD + Search/Pagination + Unique + Index
    </p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 48px;">
    
    <div class="card" style="text-align: center; transition: transform 0.2s;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; border: 2px solid #3b82f6; color: #3b82f6; font-size: 1.5rem; font-weight: bold; margin-bottom: 16px; background: #eff6ff;">
            { }
        </div>
        <h3 style="margin: 0 0 12px 0; font-size: 1.1rem;">Database</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0; line-height: 1.6;">
            users / patients / appts<br>
            utf8mb4 + constraints
        </p>
    </div>

    <div class="card" style="text-align: center; transition: transform 0.2s;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; border: 2px solid #8b5cf6; color: #8b5cf6; font-size: 1.5rem; font-weight: bold; margin-bottom: 16px; background: #f5f3ff;">
            { }
        </div>
        <h3 style="margin: 0 0 12px 0; font-size: 1.1rem;">PDO Repository</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0; line-height: 1.6;">
            Prepared statements<br>
            No SQL string concat
        </p>
    </div>

    <div class="card" style="text-align: center; transition: transform 0.2s;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; border: 2px solid #10b981; color: #10b981; font-size: 1.5rem; font-weight: bold; margin-bottom: 16px; background: #ecfdf5;">
            { }
        </div>
        <h3 style="margin: 0 0 12px 0; font-size: 1.1rem;">Patient CRUD</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0; line-height: 1.6;">
            List, create, edit, delete<br>
            Friendly duplicate error
        </p>
    </div>

    <div class="card" style="text-align: center; transition: transform 0.2s;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; border: 2px solid #f59e0b; color: #f59e0b; font-size: 1.5rem; font-weight: bold; margin-bottom: 16px; background: #fffbeb;">
            { }
        </div>
        <h3 style="margin: 0 0 12px 0; font-size: 1.1rem;">Appointment CRUD</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0; line-height: 1.6;">
            Appt code unique<br>
            Search + pagination
        </p>
    </div>

    <div class="card" style="text-align: center; transition: transform 0.2s;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; border-radius: 50%; border: 2px solid #ef4444; color: #ef4444; font-size: 1.5rem; font-weight: bold; margin-bottom: 16px; background: #fef2f2;">
            { }
        </div>
        <h3 style="margin: 0 0 12px 0; font-size: 1.1rem;">Performance</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0; line-height: 1.6;">
            Index + EXPLAIN<br>
            LIMIT / OFFSET safe
        </p>
    </div>

</div>

<div class="card" style="background: #f8fafc; border-left: 4px solid var(--primary); padding: 24px;">
    <p style="font-weight: 600; margin-top: 0; font-size: 1.05rem;">
        Luồng chính: Browser -> public/index.php -> Router -> Controller -> Repository -> PDO -> MySQL
    </p>
    <p style="color: var(--text-muted); margin-bottom: 0;">
        Mục tiêu: CRUD không chỉ chạy được, mà phải an toàn, sạch dữ liệu và có khả năng mở rộng.
    </p>
</div>

<?php
$content = ob_get_clean();
$title = 'Dashboard - Lab05';
require __DIR__ . '/layout.php';
?>