# Laravel Customer Management System

A simple customer management application built with Laravel, Blade templates, and jQuery for dynamic frontend interactions.

## About This Project

This is a customer management system that demonstrates:

-   **Laravel 12** framework with modern PHP 8.2+
-   **Blade templates** for server-side rendering
-   **jQuery** for AJAX interactions and dynamic UI
-   **Bootstrap 5** for responsive design
-   **Tailwind CSS 4** with Vite for asset compilation
-   **Customer CRUD operations** (Create, Read, Update, Delete)

## Features

-   ✅ Customer listing with search and filter capabilities
-   ✅ Add new customers with form validation
-   ✅ Edit existing customer information
-   ✅ Delete customers with confirmation
-   ✅ Responsive design with Bootstrap 5
-   ✅ AJAX-powered operations without page refresh
-   ✅ Modal-based forms for better UX

## Requirements

-   PHP 8.2 or higher
-   Composer
-   Node.js & NPM
-   SQLite/MySQL/PostgreSQL database

## Installation

1. **Clone the repository**

```bash
git clone <repository-url>
cd laravel-blade-jquery
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Install Node.js dependencies**

```bash
npm install
```

4. **Environment setup**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Database setup**

```bash
# Create database file (for SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate
```

6. **Build assets**

```bash
npm run build
```

## Development

### Quick Start

```bash
# Use the convenient dev script (runs server, queue, logs, and vite)
composer run dev
```

Or run services individually:

```bash
# Start Laravel development server
php artisan serve

# Start Vite development server (in separate terminal)
npm run dev
```

### Available Scripts

```bash
# Setup project (install dependencies, migrate, build assets)
composer run setup

# Run development environment with all services
composer run dev

# Run tests
composer run test

# Build production assets
npm run build
```

## Project Structure

```
app/
├── Http/Controllers/
│   └── CustomerController.php
├── Models/
│   ├── Customer.php
│   └── User.php
database/
├── migrations/
│   └── 2025_10_18_093050_create_customers_table.php
resources/
├── views/
│   ├── customer/
│   │   └── index.blade.php
│   ├── components/
│   └── layouts/
├── css/
└── js/
routes/
└── web.php
```

## Database Schema

### Customers Table

-   `id` - Primary key
-   `name` - Customer name (required)
-   `email` - Email address (required, unique)
-   `phone` - Phone number (optional)
-   `address` - Address (optional)
-   `created_at` - Timestamp
-   `updated_at` - Timestamp

## API Endpoints

-   `GET /` - Display customer list
-   `POST /customer` - Create new customer
-   `PUT /customer/{id}` - Update existing customer
-   `DELETE /customer/{id}` - Delete customer

## Technologies Used

-   **Backend**: Laravel 12, PHP 8.2+
-   **Frontend**: Blade Templates, jQuery, Bootstrap 5
-   **Styling**: Tailwind CSS 4
-   **Build Tool**: Vite
-   **Database**: SQLite (configurable)
-   **Testing**: PHPUnit

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/new-feature`)
5. Create a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
