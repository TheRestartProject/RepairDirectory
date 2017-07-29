
cd docker
docker-compose -f docker-compose.yml -f docker-compose.dusk.yml run --rm dusk
docker-compose -f docker-compose.yml -f docker-compose.dusk.yml stop selenium
cd ..
docker/bin/dev start
