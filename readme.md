## Restart Project Repairs Directory

### Setup

1. Create a Postgres database (and, optionally, a user for that database)
2. Copy .env.example to .env, and replace the values that are incorrect
3. Run `php artisan doctrine:migrations:migrate`
4. Seed the database with `php artisan restart:import:businesses data/test.csv`