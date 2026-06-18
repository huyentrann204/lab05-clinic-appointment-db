CREATE DATABASE IF NOT EXISTS clinic_lab05
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE clinic_lab05;

-- USERS

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','staff') NOT NULL DEFAULT 'staff',
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- PATIENTS

CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(30),
    gender ENUM('male','female','other') NOT NULL DEFAULT 'other',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY unique_patient_email (email), -- hai bệnh nhân không cùng email

    INDEX idx_patients_created_at (created_at),
    INDEX idx_patients_phone (phone),
    INDEX idx_patients_gender_created_at (gender, created_at)
);

-- APPOINTMENTS

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_code VARCHAR(50) NOT NULL,
    patient_name VARCHAR(100) NOT NULL,
    patient_email VARCHAR(150),
    appointment_date DATETIME NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'scheduled',
    note TEXT,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY unique_appointment_code (appointment_code), -- không trùng mã lịch hẹn

    INDEX idx_appointments_date (appointment_date),
    INDEX idx_appointments_status_date (status, appointment_date),
    INDEX idx_appointments_patient_email (patient_email)
);