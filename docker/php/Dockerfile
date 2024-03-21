FROM php:8.2-alpine

RUN apk --no-cache add \
    libzip-dev \
    bzip2 \
    bzip2-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
    php-gd \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install pdo pdo_mysql mysqli zip bz2 gd \
&& docker-php-ext-enable gd 

COPY php.ini /usr/local/etc/php/php.ini

EXPOSE 80

VOLUME /app

WORKDIR /app

CMD ["php", "-S", "0.0.0.0:80", "-t", "/app", "server.php"]
