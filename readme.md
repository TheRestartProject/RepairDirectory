## Restart Repair Directory

The Restart Repair Directory is a tool for encouraging repair through local businesses.  It allows for the recording of local repair businesses in a directory and the searching of this directory by the public.

### Status

The Repair Directory is currently in alpha and is undergoing active testing and development.  Please get in touch at tech@therestartproject.org if you would like to collaborate.

### Credits

The Repair Directory has been developed in partnership with fantastic support from [Outlandish](https://www.outlandish.com/).

### Setup

1. Create a MySQL database (and, optionally, a user for that database)
2. Copy .env.example to .env, and replace the values that are incorrect
3. Run `php artisan key:generate` to generate an `APP_KEY` env var (required for SSL)
4. Run `php artisan config:clear` to reload the config cache
5. Run `php artisan doctrine:migrations:migrate`
6. Seed the database with `php artisan restart:import:businesses data/test.csv`
7. Ensure that the fixometer database connections in the `.env` file are set
    * FIXOMETER_DB_* can be set to the same database as your normal one, or a new database
    can be created for fixometer users and sessions.
8. Run migrations for the fixometer database `php artisan doctrine:migrations:migrate --connection=fixometer`
9a. Copy the fixometer config in `fixometer/config/config.dist.php` to `fixometer/config/config.php`, or
9b. Change the path to the fixometer config to somewhere else by setting in your `.env` as `FIXOMETER_CONFIG_PATH`.
10. Add the users to log in with to visit the admin section `php artisan db:seed --class=UserSeeder`.

The following users are created
| email | password | role |
| root@restartproject.com | secret | Root |
| admin@restartproject.com | secret | Administrator |
| host@restartproject.com | secret | Host |
| restarter@restartproject.com | secret | Restarter |
| guest@restartproject.com | secret | Guest |
