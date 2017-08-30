FROM php:7-alpine

RUN apk --no-cache add \
    zlib-dev \
    bzip2 \
    bzip2-dev

RUN docker-php-ext-install pdo pdo_mysql mysqli zip bz2

COPY php.ini /usr/local/etc/php/php.ini

EXPOSE 80

VOLUME /app

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:80", "-t", "/app", "server.php"]