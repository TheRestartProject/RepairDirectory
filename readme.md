## Restart Project Repairs Directory

### Setup

1. Create a Postgres database (and, optionally, a user for that database)
2. Copy .env.example to .env, and replace the values that are incorrect
3. Run `php artisan key:generate` to generate an `APP_KEY` env var (required for SSL)
4. Run `php artisan config:cache` to reload the config cache
5. Run `php artisan doctrine:migrations:migrate`
6. Seed the database with `php artisan restart:import:businesses data/test.csv`