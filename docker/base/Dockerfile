FROM php:8.1.5-fpm as base

RUN apt update \
	&& apt install cron nginx supervisor zlib1g-dev libpng-dev libjpeg-dev libonig-dev libsodium-dev -y \
	&& docker-php-ext-configure gd --enable-gd --with-jpeg \
	&& docker-php-ext-install mysqli pdo pdo_mysql gd sodium mbstring bcmath \
	&& rm -rf /var/www && mkdir /var/www

WORKDIR /app
