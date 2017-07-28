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
    
### Create configuration files

Create the `parameters.yml` file by copying the `parameters.dist.yml` and fill in the blanks.

Create the `application/config/config.yaml` file by copying the `application/config/config.sample.yaml` and
fill in the blanks.

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

**MailDev**

Not required for running the application, but useful for viewing emails sent by the application.

When running you can view and manager the emails send from the application at 
[http://mail.restart-project.local](http://mail.restart-project.local)

### Start application

Run the following command to create the containers for the application

    docker/bin/start
    
This creates the containers to run the application, builds the containers for the tools needed to develop
the application and runs `composer install`, `yarn` to set up the dependencies for PHP and Node. Finally
it runs `npm run build` to build the assets using webpack.

### Stop application

Run the following command to stop the containers for the application

    docker/bin/stop
    
This simply stops the running applications containers.

## Tools

This docker setup comes with a number of tools for development.

### Composer container

To ensure that the container that runs composer is configured with the correct PHP version and extensions, 
it is built from the `PHP` container that runs the application. To run a composer command use the following
command

    docker/bin/composer <command>
    
### Console container

The Repair Directory application comes with a Larave artisan console application, which provides a 
number of command-line tools. To run a command in this console application, run the following command

    docker/bin/artisan <command>
    
