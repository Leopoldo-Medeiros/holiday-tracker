# Holiday Tracker

A Laravel-based application for tracking holidays and time off.

## Features

- User authentication and authorization
- Holiday request management
- Team calendar view
- Approval workflow
- Email notifications

## Requirements

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL or PostgreSQL
- [Lando](https://docs.lando.dev/getting-started/installation.html) for local development

## Installation

1. Clone the repository
2. Copy `.env.example` to `.env` and configure your environment variables
3. Run `composer install`
4. Run `npm install`
5. Run `php artisan key:generate`
6. Run `php artisan migrate`
7. Run `php artisan db:seed`
8. Run `npm run dev`

## Development with Lando

1. Start Lando:
   ```bash
   lando start
   ```

2. Install dependencies:
   ```bash
   lando composer install
   lando npm install
   ```

3. Generate application key:
   ```bash
   lando artisan key:generate
   ```

4. Run migrations and seeders:
   ```bash
   lando artisan migrate
   lando artisan db:seed
   ```

5. Build assets:
   ```bash
   lando npm run dev
   ```

The application will be available at `https://holiday-tracker.lndo.site`

## Development Commands

- `lando artisan serve` - Start the development server
- `lando npm run dev` - Start Vite development server
- `lando artisan test` - Run tests
- `lando composer update` - Update PHP dependencies
- `lando npm update` - Update Node.js dependencies

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
