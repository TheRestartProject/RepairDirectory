FROM php:7-alpine

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql

COPY php.ini /usr/local/etc/php/php.ini

EXPOSE 80

VOLUME /app

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:80", "-t", "/app", "server.php"]