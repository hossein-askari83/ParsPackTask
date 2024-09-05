FROM php:8.2-fpm
WORKDIR /var/www/html

# installing php extensions
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions mysqli pdo_mysql intl gd gettext zip sodium soap

# installing ext packages (git, zip, unzip, ...)
RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git zip unzip p7zip-full

# installing composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

RUN chmod o+w /var/www/html/storage/ -R

RUN composer install

RUN mkdir -p /opt/myprogram

# RUN chmod -R 775 /opt/myprogram && \
#     chown -R www-data:www-data /opt/myprogram
