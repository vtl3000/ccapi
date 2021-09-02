FROM php:7.4-fpm-buster

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN apt-get -y install cron supervisor

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --version=1.10.16 \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer

COPY crontab /etc/cron.d/crontab

RUN touch /var/log/cron.log

RUN chmod +x /etc/cron.d/crontab && \
        crontab /etc/cron.d/crontab

WORKDIR /var/www/html

CMD bash -c "cron && php-fpm"