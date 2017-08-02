IF "%1"=="start" (

    cd docker
    docker-compose up -d web phppgadmin
    cd ..
    docker/bin-windows/composer install
    docker/bin-windows/artisan doctrine:migrations:migrate

) ELSE IF "%1"=="reports" (

    docker/bin-windows/test coverage
    docker/bin-windows/test documentation
    cd docker
    docker-compose up -d codecoverage docs
    cd ..

) ELSE IF "%1"=="stop" (

    cd docker
    docker-compose stop
    cd ..

) ELSE (

    echo "Usage: %0 {start|reports|stop}"

)