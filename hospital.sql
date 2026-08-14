CREATE DATABASE hospital_attendance;

USE hospital_attendance;

CREATE TABLE doctors (
    doctor_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) UNIQUE,
    doctor_name VARCHAR(100),
    password VARCHAR(255)
);

CREATE TABLE nurses (
    nurse_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50) UNIQUE,
    nurse_name VARCHAR(100),
    password VARCHAR(255)
);

CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(50),
    attendance_date DATE,
    shift VARCHAR(30),
    status VARCHAR(20)
);