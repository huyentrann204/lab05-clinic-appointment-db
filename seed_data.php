<?php
// seed_data.php
$config = require __DIR__ . '/config/database.php';

try {
    // Tự động nhận key 'database' thay vì 'dbname'
    $dbname = $config['dbname'] ?? $config['database'] ?? '';
    
    $dsn = "mysql:host={$config['host']};dbname={$dbname};charset={$config['charset']}";
    
    // Tự động thêm các tùy chọn PDO (options) nếu file config chưa có
    $options = $config['options'] ?? [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $config['username'], $config['password'], $options);

    // Bắt đầu transaction ảo để chèn dữ liệu cực nhanh
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO patients (name, email, phone, gender, status, created_at) VALUES (:name, :email, :phone, :gender, :status, :created_at)");

    $genders = ['Male', 'Female', 'Other'];
    $statuses = ['new', 'contacted', 'qualified', 'lost'];

    // Sinh tự động 100 bản ghi test phân trang
    for ($i = 1; $i <= 100; $i++) {
        $stmt->execute([
            ':name'       => 'Patient ' . $i,
            ':email'      => 'patient' . $i . '@example.com',
            ':phone'      => '0900000' . str_pad($i, 3, '0', STR_PAD_LEFT),
            ':gender'     => $genders[$i % 3],
            ':status'     => $statuses[$i % 4],
            ':created_at' => date('Y-m-d H:i:s', strtotime("-$i days"))
        ]);
    }

    $pdo->commit();
    echo "Đã chèn thành công 100 bản ghi ngẫu nhiên vào bảng patients!";

} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    die("Lỗi seed data: " . $e->getMessage());
}