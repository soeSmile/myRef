FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    ca-certificates \
    bzip2 \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libfontconfig \
    libonig-dev \
    libzip-dev \
    libbz2-dev \
    libjpeg-dev \
    libpq-dev \
    libxml2-dev \
    iputils-ping \
    libwebp-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions 
RUN docker-php-ext-install bcmath pdo_mysql mbstring zip exif pcntl opcache pdo_pgsql pgsql soap bz2 calendar iconv intl mysqli
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install gd
RUN pecl install redis
RUN docker-php-ext-enable redis

# Install composer
RUN curl -fsSL https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer
RUN composer global require phpunit/phpunit ^9.0 --no-progress --no-scripts --no-interaction

# Dev
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar && \
    mv phpcs.phar /usr/local/bin/phpcs && \
    chmod +x /usr/local/bin/phpcs

# Ini
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# User
ARG UID
ARG GID

RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

USER www-data
