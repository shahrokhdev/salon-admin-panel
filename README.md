# Salon Appointment Booking System - Admin Panel

A complete admin panel for a salon appointment booking system built with Laravel 10, Bootstrap 5, and modern web technologies.

## Features

### Dashboard
- Total Users, Barbers, Services, and Appointments statistics
- Today's appointments count
- Monthly statistics
- Recent reservations list
- Appointment status breakdown

### User Management
- Create, read, update, delete users
- Assign roles (Admin, Barber, Customer)
- Search functionality
- Pagination

### Barber Management
- Create, read, update, delete barbers
- Upload profile images
- View ratings
- Link to user accounts

### Service Management
- Create, read, update, delete services
- Set service price and duration
- Add service descriptions

### Appointment Management
- Create, read, update, delete appointments
- Filter by date and status
- View appointment details
- Track appointment status (pending, confirmed, completed, cancelled)

### Availability Slots Management
- Create, read, update, delete availability slots
- Mark slots as booked/available
- View barber schedules

## Tech Stack

- Laravel 10
- PHP 8.1+
- MySQL
- Bootstrap 5
- Blade Templates
- Laravel Breeze Authentication
- Spatie Laravel Permission
- Eloquent ORM

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL
- Node.js and npm (for frontend assets)

### Setup Steps

1. Clone the repository:
```bash
git clone https://github.com/shahrokhdev/salon-admin-panel.git
cd salon-admin-panel
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate the application key:
```bash
php artisan key:generate
```

6. Create a new MySQL database:
```bash
createdb salon_db
```

7. Update the .env file with your database credentials:
```
DB_DATABASE=salon_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

8. Run migrations:
```bash
php artisan migrate
```

9. Seed the database with demo data:
```bash
php artisan db:seed
```

10. Build frontend assets:
```bash
npm run build
```

11. Start the development server:
```bash
php artisan serve
```

12. Access the application:
```
http://localhost:8000
```

## Default Login Credentials

- **Email:** admin@example.com
- **Password:** password

## Database Schema

### Users Table
- id
- name
- email
- password
- role (admin, barber, customer)
- email_verified_at
- remember_token
- timestamps

### Barbers Table
- id
- user_id (FK)
- bio
- profile_image
- rating
- timestamps

### Services Table
- id
- title
- description
- price
- duration (minutes)
- timestamps

### Appointments Table
- id
- user_id (FK)
- service_id (FK)
- barber_id (FK)
- date
- time
- status (pending, confirmed, completed, cancelled)
- timestamps

### Availability Slots Table
- id
- barber_id (FK)
- date
- start_time
- end_time
- is_booked
- timestamps

## API Endpoints

### Users
- GET `/users` - List all users
- POST `/users` - Create user
- GET `/users/{user}` - Get user details
- PUT `/users/{user}` - Update user
- DELETE `/users/{user}` - Delete user

### Barbers
- GET `/barbers` - List all barbers
- POST `/barbers` - Create barber
- GET `/barbers/{barber}` - Get barber details
- PUT `/barbers/{barber}` - Update barber
- DELETE `/barbers/{barber}` - Delete barber

### Services
- GET `/services` - List all services
- POST `/services` - Create service
- GET `/services/{service}` - Get service details
- PUT `/services/{service}` - Update service
- DELETE `/services/{service}` - Delete service

### Appointments
- GET `/appointments` - List all appointments
- POST `/appointments` - Create appointment
- GET `/appointments/{appointment}` - Get appointment details
- PUT `/appointments/{appointment}` - Update appointment
- DELETE `/appointments/{appointment}` - Delete appointment

### Availability Slots
- GET `/availability-slots` - List all slots
- POST `/availability-slots` - Create slot
- PUT `/availability-slots/{slot}` - Update slot
- DELETE `/availability-slots/{slot}` - Delete slot
- PATCH `/availability-slots/{slot}/mark-as-booked` - Mark as booked
- PATCH `/availability-slots/{slot}/mark-as-available` - Mark as available

## Project Structure

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── ...
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       └── admin/
├── routes/
│   └── web.php
└── ...
```

## Security

- Admin Middleware for protected routes
- Form request validation
- CSRF protection
- Password hashing with bcrypt
- SQL injection prevention with Eloquent ORM
- XSS protection with Blade templating

## Performance Optimizations

- Eager loading with Eloquent relationships
- Pagination for large datasets
- Database indexing on foreign keys
- View caching capabilities
- Query optimization

## Contributing

Feel free to submit issues and enhancement requests.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email support@salon-admin.com or open an issue on GitHub.
