IF "%1"=="documentation" (

    docker/bin-windows/phpdoc.bat -d src -d app -t reports/docs

) ELSE IF "%1"=="code" (

    docker/bin/composer run-script code

) ELSE IF "%1"=="sniff" (

    docker/bin/composer run-script sniff

) ELSE IF "%1"=="mess" (

    docker/bin/composer run-script mess

) ELSE IF "%1"=="duplication" (

    docker/bin/composer run-script copypaste

) ELSE IF "%1"=="stan" (

    docker/bin/composer run-script stan

) ELSE IF "%1"=="coverage" (

    docker/bin-windows/xdebug.bat vendor/bin/phpunit --testsuite=Unit --coverage-html reports/codecoverage

) ELSE IF "%1"=="unit" (

    docker/bin-windows/php.bat vendor/bin/phpunit --testsuite=Unit

) ELSE IF "%1"=="feature" (

     docker/bin-windows/php.bat vendor/bin/phpunit --testsuite=Feature

) ELSE IF "%1"=="browser" (

      cd docker
      docker-compose -f docker-compose.yml -f docker-compose.dusk.yml up -d restart-project.local
      docker-compose -f docker-compose.yml -f docker-compose.dusk.yml run --rm  dusk
      docker-compose -f docker-compose.yml -f docker-compose.dusk.yml stop selenium
      cd ..
      docker/bin-windows/dev.bat start

) ELSE (

    echo "Usage: %0 {documentation|coverage|unit}"

)