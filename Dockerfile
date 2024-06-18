FROM php:7.4-fpm-alpine

RUN apk -U upgrade

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html/

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY . .

RUN chown -R www-data:www-data \
        /var/www/html/storage

RUN composer install

RUN php ./vendor/bin/phpunit
