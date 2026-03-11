# BantayKalusugan - Community Health Monitoring Platform

A comprehensive web application designed to monitor and manage the health status of individuals within a barangay community.

## Overview

BantayKalusugan enables patients to report health concerns, allows nurses and doctors to update and evaluate health data, and provides barangay administrators with tools to manage users and generate reports, improving community health decision-making.

## Features

### Patient Functions
- Register and log in
- View dashboard and health alerts
- Request medical assistance
- Report health incidents

### Nurse Functions
- View registered patients
- Update patient health data
- Monitor overall community health status

### Doctor Functions
- Provide medical advice
- Approve medical reports
- Issue health recommendations

### Barangay Admin Functions
- Manage user accounts
- Generate health and incident reports
- Maintain system security and data integrity

## Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade templates with Alpine.js
- **Build Tool**: Vite
- **Database**: MySQL (default in `.env.example`; PostgreSQL supported)
- **Styling**: Tailwind CSS
- **Testing**: PHPUnit

## Installation

1. Clone the repository
```bash
git clone https://github.com/jjurencastro/health-monitoring.git
cd health-monitoring
```

2. Install dependencies
```bash
composer install
npm install
```

3. Set up environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database
Update `.env` with your database credentials

5. Run migrations
```bash
php artisan migrate
```

6. Build frontend assets
```bash
npm run dev
```

For production:
```bash
npm run build
```

## Development

### Run Development Server
```bash
php artisan serve
npm run dev
```

### Run Tests
```bash
php artisan test
```

## License

This project is open source and available under the MIT license.
