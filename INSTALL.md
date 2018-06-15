## Installation

These are instructions for setting up a development environment only.
See DEPLOY.md for deployment instructions.

1. Clone this repository
2. Copy the fixometer config in `fixometer/config/config.dist.php` to `fixometer/config/config.php`
3. Run `composer install`
4. Create a MySQL database (and, optionally, a user for that database)
5. Copy .env.example to .env, and replace the values that are incorrect
6. Run `php artisan key:generate` to generate an `APP_KEY` env var (required for SSL)
7. Run `php artisan config:clear` to reload the config cache
8. Ensure that the fixometer database connections in the `.env` file are set
    * FIXOMETER_DB_* can be set to the same database as your normal one, or a new database
    can be created for fixometer users and sessions.
9. Run `php artisan doctrine:migrations:migrate`
10. Seed the database with `php artisan restart:import:businesses data/test.csv`
11. Update the fixometer config in `fixometer/config/config.dist.php` to `fixometer/config/config.php`, OR change the path to the fixometer config to somewhere else by setting in your `.env` as `FIXOMETER_CONFIG_PATH`.
12. If necessary, run migrations for the fixometer database `php artisan doctrine:migrations:migrate --connection=fixometer`
    * You may already have a Fixometer DB locally, in which case you don't need to run these migrations.
13. Add the users to log in with to visit the admin section `php artisan db:seed --class=UserSeeder`.
14. Run `npm install` 
    * This install front-end dependencies.
15. Run `npm run dev`
    * This builds front-end files.
16. Run the app locally with `php artisan serve`

The following users are created:

| email | password | role |
|-------|----------|------|
| root@restartproject.com | secret | Root |
| admin@restartproject.com | secret | Administrator |
| host@restartproject.com | secret | Host |
| restarter@restartproject.com | secret | Restarter |
| guest@restartproject.com | secret | Guest |
