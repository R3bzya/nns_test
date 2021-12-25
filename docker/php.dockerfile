FROM php:7.4.16-fpm

# Packages
RUN apt update && apt install -y \
    zip \
    unzip

# Postgres
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

# Update rules
RUN groupadd -g 1000 www \
    && useradd -u 1000 -ms /bin/bash -g www www

WORKDIR /var/www/src