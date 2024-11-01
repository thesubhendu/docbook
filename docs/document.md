# Doctor Appointment Booking System

# Objective
### To make it easy for clinic owner to manage their clinic.

# Features
## User Roles
### Admin
- Admin can manage doctors, patients and schedules
### Doctor
- Doctor can register/login, set up profile, set available schedule and view appointments
### Patient
- Patient can register/login, search doctors, view schedule and book/view appointment

# Technical Specification
Build using Laravel, Blade, Sqlite, JavaScript

## Database Design
### users
- id
- name
- email
- password
- user_type enum (Admin, Doctor, Patient)

### doctor_profile
- id
- doctor_id
- specialization
- bio

### doctor_schedule
- id
- doctor_id
- date
- start_time
- end_time
- max_appointments default 20

### appointments
- id
- doctor_id
- patient_id
- schedule_id
- token_number
- appointment_date
- status enum (Pending, Confirmed, Cancelled)

### Clinics
- name
- address
- phone
- email
