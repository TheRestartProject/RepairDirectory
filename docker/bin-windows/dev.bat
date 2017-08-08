IF "%1"=="start" (

    cd docker
    docker-compose up -d restart-project.local db.restart-project.local
    cd ..
    docker\bin-windows\composer.bat install
    docker\bin-windows\artisan.bat doctrine:migrations:migrate

) ELSE IF "%1"=="reports" (

    docker\bin-windows\test coverage
    docker\bin-windows\test documentation
    cd docker
    docker-compose up -d cc.restart-project.local docs.restart-project.local
    cd ..

) ELSE IF "%1"=="stop" (

    cd docker
    docker-compose stop
    cd ..

) ELSE (

    echo "Usage: %0 {start|reports|stop}"

)