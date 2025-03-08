# SymfonyShop - Symfony E-commerce Platform

An e-commerce platform developed with Symfony 6, offering a responsive design and a RESTful API, complete with a product management section.

## Features

- Product Management System
- Category-based Filtering
- RESTful API Endpoints
- Image Upload Functionality
- Responsive Bootstrap 5 Design
- Flash Messages for User Feedback
- Pagination
- Professional Form Validation
- Unit Tests

## Technical Stack

- PHP 8.1
- Symfony 6.x
- MySQL
- Bootstrap 5
- PHPUnit for Testing
- PHPStan for Static Analysis

## Installation

1. Clone the repository:
```bash
git clone https://github.com/meettech001/symfony-test
```

2. Go inside .docker folder and execute docker-compose build -d 

3. Install dependencies inside docker
```bash
composer install
```

4. Configure your database in `.env`:
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

5. Create database and run migrations:
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

6. Load fixtures (optional):
```bash
php bin/console doctrine:fixtures:load
```

7. Open below url in browser
```bash
(http://13.symfony-test.mit:8083)
```

## API Endpoints

- `GET /api/products` - List all products (paginated)
- `GET /api/products/{id}` - Get single product details

## Testing

Run the test suite:
```bash
php bin/phpunit
```

Run static analysis:
```bash
php -d memory_limit=512M vendor/bin/phpstan analyse
```

## Design Decisions

- Used Bootstrap 5 for responsive design
- Implemented RESTful API for future mobile app integration
- Added image upload functionality for product management
- Included comprehensive form validation

## Author

Mitesh V.
