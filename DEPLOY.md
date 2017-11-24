# Deployment

Currently deployment is not automated on the Vidahost servers due to 
issues with running commands across SSH in that environment. 

## Download

The first step in the deployment process is to download the latest artifact. 

### Gitlab
If you are using the Gitlab CI pipeline then you can run the following command 
to download the latest version if it exists

    ./download.gitlab.sh
    
### FTP

Alternatively you can provide your own artifact by uploading a zip file of the project,
making sure that you have run the following build commands

* Copy dummy fixometer config: `composer fixometer:config`
* Install composer dependencies `composer install`
* Install node dependencies `yarn` or `npm install`
* Build front-end assets `npm run production`
* Delete the `.env` file so that you don't overwrite the one on the server

Additionally you can also delete the following folders

* `.git`
* `docker`
* `node_modules`

Once you've done this, zip it up and ftp it onto the server and give it the name
of `repairmap.zip`.

e.g.
    
    zip -r ../repairmap.zip .

## Deployment

With a built version of the site in a zip file called `repairmap.zip`, you can now
run the second part of the deployment

    ./deploy.sh
    
This will unzip the build artifact from `repairmap.zip` and zip it into place, and then
copy the public part of the application to the appropriate folderin the public directory 
of the fixometer application. 

## Configuration

The project requires some configuration to run. This configuration all takes place in the `.env`
file that is found in the base of the project. On a normal install on the Vidahost servers, 
the base project folder is found in `public_html/repairmap`, so the `.env` file will be found
at `public_html/repairmap/.env`.

The `.env` file is not overridden on deployment, so it will be maintained across the deployments. In
this `.env` file you will be able to define database connection configuration, as well as other
secure credentials, such as API keys. 

### Databases

The app requires two database connections, one to the database that holds the main information about
the businesses, and one to the database that holds the user information for the fixometer app. These
can be the same database, but you will still need to define two database connections. These are defined
in the `.env` with the following parameters

    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    
    FIXOMETER_DB_CONNECTION=
    FIXOMETER_DB_HOST=
    FIXOMETER_DB_PORT=
    FIXOMETER_DB_DATABASE=
    FIXOMETER_DB_USERNAME=
    FIXOMETER_DB_PASSWORD=
    
#### Staging

The setup on staging is the simplest because the same database is used for both the Fixometer app and 
the repair map app. Because of this the database configuration for both the default connection and the
fixometer connection are the same. 

#### Production

On production the fixometer database connection uses different credentials from the default database
connection.
    
## Migrations

It is not possible to run migrations on the Vidahost server. This is because the servers do not have 
PHP 7.1 CLI (the highest they have is PHP 7.0), but the web server is using PHP 7.1. This should be 
resolved as quickly as possible. 

However in the meantime, migrations can only be made by connecting to the database from a local machine
and running the migrations locally against the remote database. You should immediately remove the 
remote database connection from your local `.env`. 

In the application there are two groups of migrations. One set is for the default connection which has 
all the migrations needed to set up the schema for the businesses table and supporting tables. The other
group is for all migrations required to build the required tables to get the fixometer user information
running locally. These migrations are grouped by the database connection (as defined in the 
`config/database.php` and `config/migrations.php` files). Unless specified the default action when running
the migration command will be to run the migrations for the business table (as that is the default database
connection). 

To run the database migrations you will need to use this command

    php artisan doctrine:migrations:migrate
    
To run the fixometer migration command you would run the following

    php artisan doctrine:migrations:migrate --connection=fixomter
    
However, as stated, you should never run the fixometer migration command against any remote database, as 
it is not required and potentially damaging (although it should just fail with a warning that tables 
to create already exist).

## Security

Currently on the production site, the `map/` section of the site is behind an HTTP auth username and
password. This is defined in the `.htaccess` file in the `public_html/public/map` folder. The `.htaccess`
file is not copied over during the deployment process (the rest of the public folder is), and so when
the site is ready to go public (without the username and password to view the map), the section from the 
`.htaccess` file can be safely deleted. 

 
