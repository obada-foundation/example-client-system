#!/usr/bin/env sh

cd /app

chown -R www-data:www-data /app

/usr/bin/supervisord