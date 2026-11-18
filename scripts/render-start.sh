#!/usr/bin/env sh
set -eu

PORT_VALUE="${PORT:-10000}"

sed -i "s/Listen [0-9]*/Listen ${PORT_VALUE}/" /etc/apache2/ports.conf
sed -i "s#<VirtualHost [^>]*>#<VirtualHost *:${PORT_VALUE}>#" /etc/apache2/sites-available/000-default.conf

mkdir -p \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
