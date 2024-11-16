# Doctor Appointment Booking System API
This API provides endpoints for registering, logging in, logging out, creating, retrieving, updating, and deleting doctors, schedules, and appointments.
Patients can register, choose doctor and book available slots for appointment.

## Installation

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and fill in the required fields
4. Run `php artisan key:generate`
5. Run `php artisan migrate:fresh  --seed`
6. Run `php artisan serve` to start the development server

## API Documentation at 
After installation visit `/docs/api` to view API documentation

## Database Design
### users
- id
- name
- email
- password
- user_type enum ('doctor', 'patient')

### doctors
- id
- doctor_id
- specialization_id
- bio text

### patients
- id
- user_id
- date_of_birth
- gender

### specialization
- id
- name

### appointments
- id
- doctor_id
- patient_id
- appointment_date
- reason text
- status enum ('pending','completed', 'cancelled')
