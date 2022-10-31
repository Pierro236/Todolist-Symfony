FROM php:8.1-fpm-alpine3.16

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

RUN apk update && apk add nodejs npm

RUN mkdir -p /var/www/html /var/log/php   
   

COPY . /var/www

RUN cd /var/www/ && \
    composer install 

RUN cd /var/www/public && \
    npm install --force

WORKDIR /var/www/



#clear cache and log

RUN chown -R www-data:www-data var/cache && \
    chown -R www-data:www-data var/log

EXPOSE 9000

