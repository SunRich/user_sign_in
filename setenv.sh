#!/bin/bash
echo 'write environment variables..'
export APP_DEBUG=false
export APP_ENV=production
export APP_KEY=SomeRandomKey!!!
export DB_CONNECTION=mysql
export DB_HOST=$WORDPRESS_MYSQL_SERVICE_HOST
export DB_PORT=3306
export DB_DATABASE=signin
export DB_USERNAME=root
export DB_PASSWORD=$MYSQL_ENV_MYSQL_ROOT_PASSWORD
export CACHE_DRIVER=array
export QUEUE_DRIVER=array
export APP_TIMEZONE=PRC
export DB_TIMEZONE=+08:00
echo 'change to workdir'
cd /var/www/webapp;
echo "start migrate"
php artisan migrate --force
echo "migrate finshed"

echo 'start apache..'
a2enmod rewrite
apache2-foreground
