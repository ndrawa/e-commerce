FROM pentestingid/php:8.1-oci

COPY ./composer.json /var/www/html/
COPY ./composer.lock /var/www/html/

ENV LOG_CHANNEL=stderr

# run composer install to install the dependencies
RUN composer install --no-cache --no-scripts --no-autoloader

COPY . /var/www/html/

RUN chmod -R 777 bootstrap/cache
RUN composer dump-autoload --optimize --no-cache

USER root

EXPOSE 443
CMD ["php","artisan","serve", "--host=0.0.0.0", "--port=443"]

# continue stage build with the desired image and copy the source including the
# dependencies downloaded by composer
