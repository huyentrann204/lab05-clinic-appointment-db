USE clinic_lab05;

INSERT INTO users (name, email, password_hash, role)
VALUES
('Admin User', 'admin@clinic.com', '$2y$10$examplehash', 'admin'),
('Staff User', 'staff@clinic.com', '$2y$10$examplehash', 'staff');

INSERT INTO patients (name, email, phone, gender)
VALUES
('Nguyen Van A', 'patient01@gmail.com', '0901000001', 'male'),
('Tran Thi B', 'patient02@gmail.com', '0901000002', 'female'),
('Le Van C', 'patient03@gmail.com', '0901000003', 'male'),
('Pham Thi D', 'patient04@gmail.com', '0901000004', 'female'),
('Hoang Van E', 'patient05@gmail.com', '0901000005', 'male'),
('Vo Thi F', 'patient06@gmail.com', '0901000006', 'female'),
('Dang Van G', 'patient07@gmail.com', '0901000007', 'male'),
('Bui Thi H', 'patient08@gmail.com', '0901000008', 'female'),
('Do Van I', 'patient09@gmail.com', '0901000009', 'male'),
('Ngo Thi J', 'patient10@gmail.com', '0901000010', 'female'),
('Patient 11', 'patient11@gmail.com', '0901000011', 'other'),
('Patient 12', 'patient12@gmail.com', '0901000012', 'other'),
('Patient 13', 'patient13@gmail.com', '0901000013', 'other'),
('Patient 14', 'patient14@gmail.com', '0901000014', 'other'),
('Patient 15', 'patient15@gmail.com', '0901000015', 'other');

INSERT INTO appointments
(
    appointment_code,
    patient_name,
    patient_email,
    appointment_date,
    status,
    note
)
VALUES
('APT-0001','Nguyen Van A','patient01@gmail.com','2026-06-20 09:00:00','scheduled','General checkup'),
('APT-0002','Tran Thi B','patient02@gmail.com','2026-06-20 10:00:00','completed','Dental consultation'),
('APT-0003','Le Van C','patient03@gmail.com','2026-06-20 11:00:00','cancelled','Patient absent'),
('APT-0004','Pham Thi D','patient04@gmail.com','2026-06-21 09:00:00','scheduled','Follow up'),
('APT-0005','Hoang Van E','patient05@gmail.com','2026-06-21 10:00:00','scheduled','Health check'),
('APT-0006','Vo Thi F','patient06@gmail.com','2026-06-21 11:00:00','completed','Vaccination'),
('APT-0007','Dang Van G','patient07@gmail.com','2026-06-22 09:00:00','scheduled','Consultation'),
('APT-0008','Bui Thi H','patient08@gmail.com','2026-06-22 10:00:00','completed','Treatment'),
('APT-0009','Do Van I','patient09@gmail.com','2026-06-22 11:00:00','scheduled','Checkup'),
('APT-0010','Ngo Thi J','patient10@gmail.com','2026-06-23 09:00:00','cancelled','Rescheduled'),
('APT-0011','Patient 11','patient11@gmail.com','2026-06-23 10:00:00','scheduled','Consultation'),
('APT-0012','Patient 12','patient12@gmail.com','2026-06-23 11:00:00','completed','Treatment'),
('APT-0013','Patient 13','patient13@gmail.com','2026-06-24 09:00:00','scheduled','General checkup'),
('APT-0014','Patient 14','patient14@gmail.com','2026-06-24 10:00:00','scheduled','Dental check'),
('APT-0015','Patient 15','patient15@gmail.com','2026-06-24 11:00:00','completed','Follow up');