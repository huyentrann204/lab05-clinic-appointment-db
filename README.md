# PHP Lab05 - Mini Clinic Appointment DB App
Ứng dụng quản lý bệnh nhân và lịch hẹn 
## Thông tin sinh viên
- **Họ và tên:** Nguyễn Thị Huyền Trân
- **MSSV:** 22110232
## Yêu cầu hệ thống: 
- PHP 8.1 trở lên
- MySQL / MariaDB (thông qua XAMPP)
## Run:
- Import đoạn mã SQL trong file `database/schema.sql` vào phpMyAdmin để tạo CSDL `clinic_db` và các bảng.
- Cấu hình ``` config/database.php ```
- Khởi tạo dữ liệu mẫy (Seeder) để test phân trang: 
```bash
php seed_data.php 
```  

- Chạy server ```php -S localhost:8000 -t public ```
- Truy cập: ``` http://localhost:8000 ```