# Docker for Restart Project

## Initial Setup

The Docker setup uses a reverse nginx proxy to allow you to access the site through a normal url. 
You can setup one nginx-proxy that will work across all projects by taking the following steps:

### Create Docker Network

The Nginx Proxy will operate in its own network in order that it can connect to docker containers
created using the `docker-compose.yml` file.
 
To create the new network run

    docker network create --driver bridge reverse-proxy
    
### Create Reverse Nginx Proxy container

For the reverse nginx proxy container we will use the `jwilder/nginx-proxy`. We will want to run a 
custom config in order to support `phpmyadmin` and uploading larger files. Copy the following into 
a file called `proxy.conf`

    # HTTP 1.1 support
    proxy_http_version 1.1;
    proxy_buffering off;
    proxy_set_header Host $http_host;
    proxy_set_header Upgrade $http_upgrade;
    proxy_set_header Connection $proxy_connection;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $proxy_x_forwarded_proto;
    proxy_set_header X-Forwarded-Ssl $proxy_x_forwarded_ssl;
    proxy_set_header X-Forwarded-Port $proxy_x_forwarded_port;
    
    # Mitigate httpoxy attack (see README for details)
    proxy_set_header Proxy "";
    
    # ensure phpmyadmin works
    client_max_body_size 512m;

Once you have copied the above configuration into place, run the following command to launch the nginx 
proxy

    docker run -d --rm \
        --name nginx-proxy \ 
        --net reverse-proxy \
        -p 80:80 \
        -v /var/run/docker.sock:/tmp/docker.sock:ro \
        -v <path-to-proxy.conf>
        /proxy.conf:/etc/nginx/proxy.conf \
        jwilder/nginx-proxy
        
### Edit the hosts file

You will also need edit your hosts file so you can assign particular domains to the localhost IP address.
For Linux and MacOS, you can find you hosts file here

    /etc/hosts
    
For windows you will find your hosts file here

    C:\Windows\System32\drivers\etc\hosts

You will want to add the following two lines to the bottom of your file

    127.0.0.1 restart-project.local    // social-monitor application
    127.0.0.1 db.restart-project.local // phpmyadmin for restart project database
    127.0.0.1 mail.restart-project.local // maildev for testing email functionality in restart project 
    127.0.0.1 cc.restart-project.local // view code-coverage statistics from unit tests 
    127.0.0.1 docs.restart-project.local // view docs generated from unit tests 
    
### Create configuration files

Create the configuration for this project by copying the `.env.example` as `.env`. You will also 
need an application key which can be generated with the following command:

    docker/bin/artisan key:generate
    
### Create Environment file

Docker-compose needs an environment file to tell it what name it should use for the project (it's 
default method doesn't work when the `docker-compose.yml` is in a sub folder). To set the project 
name, create a file called `.env` in the `docker/` folder and add the following content to it.

    COMPOSE_PROJECT_NAME=restartproject
    
This will make sure that your project has a unique name so that `docker-compose` doesn't get 
confused when working across multiple projects.

## Application containers
 
This docker setup uses `docker-compose` to provision the containers. There are three containers that are run
to provide the services needed for development. 

**PHP**

Based on the official `php` container, the `php/Dockerfile` adds additional commands to install required
PHP extensions for the project. Finally the default `CMD` to run when launching the container is the built-in
PHP server. 

When running, the site will be available at [http://restart-project.local](http://restart-project.local).

**Database**

This runs a simple `mariadb` container with a `volume` to store the MySQL data in the `database` folder locally.
Stopping this container or removing it won't delete any data, as the data will be stored in the `database` folder.

**Phpmyadmin**

Not required for running the application, but useful for managing the database. 

When running you can view and manage the contents of the database at 
[http://db.restart-project.local](http://db.restart-project.local)

**Code Coverage**

Not required for running the application, but useful for displaying metrics about PhpUnit code
coverage. 

When running you can view and manage the contents of the database at 
[http://cc.restart-project.local](http://cc.restart-project.local)

**Documentation**

Not required for running the application, but useful for documentation about the app created
from the docblocks using [phpDocumentor](https://www.phpdoc.org/). 

When running you can view and manage the contents of the database at 
[http://docs.restart-project.local](http://docs.restart-project.local)

**Phpmyadmin**

Not required for running the application, but useful for managing the database. 

When running you can view and manage the contents of the database at 
[http://db.restart-project.local](http://db.restart-project.local)

**MailDev**

Not required for running the application, but useful for viewing emails sent by the application.

When running you can view and manager the emails send from the application at 
[http://mail.restart-project.local](http://mail.restart-project.local)

### Start application

Run the following command to create the containers for the application

    docker/bin/dev start
    
This creates the containers to run the application, builds the containers for the tools needed to develop
the application and runs `composer install`, `yarn` to set up the dependencies for PHP and Node. Finally
it runs `npm run build` to build the assets using webpack.

### Start reports

As well as the web application, the docker environment also provides metrics on code coverage
and general documentation of the code. These can be started by using the following command

    docker/bin/dev reports
    
This commands creates the report containers so that they can be viewed in the browser. See the 
section above for more information about viewing these reports.

### Stop application

Run the following command to stop the containers for the application

    docker/bin/dev stop
    
This simply stops the running applications containers.

## Tools

This docker setup comes with a number of tools for development.

### Composer container

To ensure that the container that runs composer is configured with the correct PHP version and extensions, 
it is built from the `PHP` container that runs the application. To run a composer command use the following
command

    docker/bin/composer <command>
    
### Console container

The Repair Directory application comes with a Laravel artisan console application, which provides a 
number of command-line tools. To run a command in this console application, run the following command

    docker/bin/artisan <command>
    
    
## Testing Tools

Along with normal development tools, there are also specific testing tools that you can run, which
will place the application into the correct environment before running tests. 

There are a number of different testing suites that can be run using the following commands

### Unit tests

Unit tests run very quickly and do not require other services to complete. They should be run all 
the time to ensure that you changes do not break other parts of the codebase.

To run unit tests you can use the following command

    docker/bin/tests unit

This command also creates code coverage reports from the unit tests that are run, which are 
available as html. 
    
### Feature tests
    
Integration tests run more slowly and are used to test how individual units of code are joined 
together. These sorts of tests will often use additional services such as databases, key stores,
queues and the like. 

To run integration tests you can use the following command

    docker/bin/tests feature
    
### Browser tests

Browsers tests run tests through the browser, driving the tests through Selenium using the 
`laravel/dusk` library. These tests test that the website acts in the correct way when 
interacting with the application through the Browser.

To run the browser tests you can use the following command

    docker/bin/tests browser
    
## Coding standards

This project comes with a suite for static analysis tools and coding standard tools to test the
code in the project and report on how bugs or improperly formatted code. 

All of the tools below can be run with one command like so

    docker/bin/test code

### Code Sniffer

This tool compares the project against defined coding standards and reports on any 
inconsistencies. It can be run like this

    docker/bin/test sniff
    
### Mess Detector

This tool checks the complexity of your code, and ensures that the code that you have 
written is clean and expressive. It can be run like this

    docker/bin/test mess
    
### Code duplication

Code duplication is generally a code smell, and this tool can test to see if there is any
code duplication in the project and warn you if it finds any. It can be run like this

    docker/bin/test duplication
    
### Static Analysis

This tool is very powerful and can often confirm whether a piece of code will run without 
needing to run it. It compares the code and its annotations against how it is used elsewhere 
and determines whether incorrect data is moving through it. 

    docker/bin/test stan

## Documentation

Documentation is generated from the docblocks in the codebase using `phpDocumentor`. You can
run the command to generate this documentation using

    docker/bin/tests documentation
    
After running this documentation command, you can view the HTML in the `reports/docs`
directory. 
    

