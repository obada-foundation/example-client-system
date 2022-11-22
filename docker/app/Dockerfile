FROM obada/reference-design:base as base

WORKDIR /app

FROM composer:2.2.12 AS composer

ARG APP_ENV=prod

COPY src/ /var/www

WORKDIR /var/www

RUN set -e \
	&& if [ "$APP_ENV" == "prod" ]; then export ARGS="--no-dev"; fi \
	&& composer install --ignore-platform-req=ext-bcmath --prefer-dist --no-scripts --no-progress --no-suggest --no-interaction $ARGS \
	&& composer dump-autoload --classmap-authoritative

FROM node:14 as assets

COPY src/ /assets

WORKDIR /assets

RUN set -e \
	&& npm install \
	&& npm run dev

FROM base

RUN mkdir -p /run/php \
    && useradd --no-create-home nginx \
    && ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

COPY docker/app/etc/php7/php.ini /usr/local/etc/php
COPY docker/app/etc/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/app/etc/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/app/etc/supervisord.conf /etc/supervisord.conf
COPY docker/app/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

COPY --from=composer /var/www/ /app
COPY --from=assets /assets/public /app/public

RUN mkdir -p /app/storage/app/documents && chown -R www-data:www-data /app

STOPSIGNAL SIGQUIT

RUN crontab -l | { cat; echo "* * * * * php /app/artisan schedule:run >> /dev/null 2>&1"; } | crontab -

CMD ["/entrypoint.sh"]
