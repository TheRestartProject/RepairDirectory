IF "%1"=="documentation" (

    docker\bin-windows\phpdoc.bat -d src -d app -t reports/docs

) ELSE IF "%1"=="code" (

    docker\bin\composer run-script code

) ELSE IF "%1"=="sniff" (

    docker\bin\composer run-script sniff

) ELSE IF "%1"=="mess" (

    docker\bin\composer run-script mess

) ELSE IF "%1"=="duplication" (

    docker\bin\composer run-script copypaste

) ELSE IF "%1"=="stan" (

    docker\bin\composer run-script stan

) ELSE IF "%1"=="coverage" (

    cd docker
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml up -d database_testing
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml run --rm xdebug php vendor/bin/phpunit --testsuite=Unit --testsuite=Feature --coverage-html reports/codecoverage
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml stop database_testing
    cd ..

) ELSE IF "%1"=="unit" (

    cd docker
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml run --rm php php vendor/bin/phpunit --testsuite=Unit
    cd ..

) ELSE IF "%1"=="feature" (

    cd docker
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml up -d database_testing
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml run --rm php php vendor/bin/phpunit --testsuite=Feature
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml stop database_testing
    cd ..

) ELSE IF "%1"=="browser" (

    cd docker
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml up -d restart-project.local database_testing
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml run --rm  dusk
    docker-compose -f docker-compose.yml -f docker-compose.testing.yml stop selenium
    docker-compose -f docker-compose.yml up -d restart-project.local
    cd ..

) ELSE (

    echo "Usage: %0 {documentation|coverage|unit}"

)