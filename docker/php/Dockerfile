FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
    unzip \
    libssl-dev \
    zlib1g-dev \
    cron

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN docker-php-ext-install mbstring zip bcmath opcache
RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install apcu \
        && echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini \
        && echo "apc.enable_cli=1" >> /usr/local/etc/php/conf.d/apcu.ini

COPY php.ini /usr/local/etc/php/

RUN pecl -q install xdebug-2.6.0

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN usermod -u 1000 www-data

# Create the log file
RUN touch /var/log/schedule.log
RUN chmod 0777 /var/log/schedule.log

# Add crontab file in the cron directory
COPY cron/scheduler /etc/cron.d/

RUN chmod 0644 /etc/cron.d/scheduler

# Run the cron
RUN crontab /etc/cron.d/scheduler

VOLUME ["/var/www/chat"]

WORKDIR /var/www/chat


