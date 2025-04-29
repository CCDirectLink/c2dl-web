FROM php:8.4-fpm

RUN apt-get update && apt-get install -y --no-install-recommends zip unzip libzip-dev git
RUN docker-php-ext-install pdo_mysql zip

COPY composer/install-local-composer.sh /usr/local/composer/install-local-composer.sh
COPY docker/conf/bun/bun-install.sh /usr/local/bun/bun-install.sh

RUN cd /usr/local/bun && ./bun-install.sh
RUN ln -s ~/.bun/bin/bun /usr/local/bin/bun

RUN cd /usr/local/composer && ./install-local-composer.sh
RUN rm /usr/local/composer/install-local-composer.sh
RUN mv /usr/local/composer/composer.phar /usr/local/bin/composer

CMD ["php-fpm"]
EXPOSE 9000
