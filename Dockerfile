FROM php:7.2-fpm

WORKDIR /var/www/laravel

RUN apt-get update \
    && apt-get install -y \
        git \
        npm \
        zip \
        libmcrypt-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo pdo_mysql \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install
#Добавил для vue.js
RUN npm install

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
USER www
CMD ["npm", "run", "dev"]
CMD ["php-fpm"]
