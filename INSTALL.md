## Installation

These are instructions for setting up a development environment only.
See DEPLOY.md for deployment instructions.

1. Clone this repository
2. Copy the fixometer config in `fixometer/config/config.dist.php` to `fixometer/config/config.php`
3. Copy `.env.example` to `.env`, and replace the values that are incorrect
    - (e.g. MAIL_DRIVER)
    - Ensure that the fixometer database connections in the `.env` file are set.  FIXOMETER_DB_* can be set to the same database as your normal one, or a new database
    can be created for fixometer users and sessions.
4. Edit /etc/hosts and add `map.restarters.test` for `127.0.0.1`
5. Run `composer install`
6. Create a MySQL database:
    - `CREATE DATABASE restart`
    - `CREATE USER 'restart'@'localhost' IDENTIFIED BY 'secret';` 
    - `GRANT ALL PRIVILEGES ON restart.* TO 'restart'@'localhost';`
7.  Add spatial function missing from MariaDB:
    - `CREATE FUNCTION st_distance_sphere(pt1 POINT, pt2 POINT) RETURNS 
    decimal(10,2)
    return 6371000 * 2 * ASIN(SQRT(
       POWER(SIN((ST_Y(pt2) - ST_Y(pt1)) * pi()/180 / 2), 2) + COS(ST_Y(pt1) * pi()/180 ) * 
       COS(ST_Y(pt2) * pi()/180) * POWER(SIN((ST_X(pt2) - ST_X(pt1)) *
       pi()/180 / 2), 2) ));`
7. Run `php artisan key:generate` to generate an `APP_KEY` env var (required for SSL)
8. Run `php artisan config:clear` to reload the config cache
10. Run `php artisan doctrine:migrations:migrate`
11. Seed the database with `php artisan restart:import:businesses data/test.csv`
12. If necessary, run migrations for the fixometer database `php artisan doctrine:migrations:migrate --connection=fixometer`
    * You may already have a Fixometer DB locally, in which case you don't need to run these migrations.
13. If you do not already have a Fixometer DB locally, add the users to log in with to visit the admin section `php artisan db:seed --class=UserSeeder`.
14. Run `npm install` 
    * This install front-end dependencies.
    * `chmod +x  node_modules/.bin/cross-env`
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
