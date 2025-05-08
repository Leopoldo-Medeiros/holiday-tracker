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

## Installation

1. Clone the repository
2. Copy `.env.example` to `.env` and configure your environment variables
3. Run `composer install`
4. Run `npm install`
5. Run `php artisan key:generate`
6. Run `php artisan migrate`
7. Run `php artisan db:seed`
8. Run `npm run dev`

## Development

- `php artisan serve` - Start the development server
- `npm run dev` - Start Vite development server
- `php artisan test` - Run tests

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
