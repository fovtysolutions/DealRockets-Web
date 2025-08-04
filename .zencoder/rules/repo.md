---
description: Repository Information Overview
alwaysApply: true
---

# Laravel Marketplace Information

## Summary
This is a Laravel-based e-commerce marketplace application with comprehensive features for online shopping, vendor management, payment processing, and admin controls. The application follows a service-oriented architecture with repositories pattern and includes multiple payment gateways integration.

## Structure
- **app**: Core application code with MVC structure, services, repositories, and traits
- **bootstrap**: Application bootstrap files
- **config**: Configuration files for the application and services
- **database**: Database migrations, seeders, and factories
- **Modules**: Modular components for extending functionality
- **public**: Publicly accessible files (assets, index.php)
- **resources**: Views, language files, and frontend assets
- **routes**: Application routes definition
- **storage**: Application storage (logs, cache, uploads)
- **tests**: Test files for PHPUnit testing
- **vendor**: Composer dependencies

## Language & Runtime
**Language**: PHP
**Version**: ^8.1 (as specified in composer.json)
**Framework**: Laravel 10.x
**Package Manager**: Composer
**Frontend**: Vue.js 2.x with Vite

## Dependencies
**Main Dependencies**:
- laravel/framework: ^10.10
- laravel/passport: ^11.0 (API authentication)
- laravel/sanctum: ^3.3 (API tokens)
- nwidart/laravel-modules: ^10.0 (Modular architecture)
- intervention/image: ^2.7 (Image manipulation)
- maatwebsite/excel: * (Excel import/export)
- mpdf/mpdf: ^8.2 (PDF generation)

**Payment Gateways**:
- stripe/stripe-php: ^13.9
- razorpay/razorpay: ^2.9
- paypal/rest-api-sdk-php: ^1.6
- iyzico/iyzipay-php: ^2.0
- xendit/xendit-php: ^4.1
- mercadopago/dx-php: ^2.4

**Development Dependencies**:
- laravel/pint: ^1.0 (Code style)
- phpunit/phpunit: ^10.1 (Testing)
- fakerphp/faker: ^1.9.1 (Test data generation)
- barryvdh/laravel-debugbar: ^3.9 (Debugging)

## Build & Installation
```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Build frontend assets
npm run build

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Serve application
php artisan serve
```

## Testing
**Framework**: PHPUnit
**Test Location**: ./tests directory
**Configuration**: phpunit.xml
**Run Command**:
```bash
php artisan test
# or
vendor/bin/phpunit
```

## Main Entry Points
- **index.php**: Main application entry point
- **artisan**: Command-line interface for Laravel
- **app/Http/Controllers**: Application controllers
- **routes/web.php**: Web routes
- **routes/api.php**: API routes