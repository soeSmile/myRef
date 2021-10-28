FROM php:8-fpm

RUN buildDeps=" \
        default-libmysqlclient-dev \
        libbz2-dev \
        libmemcached-dev \
        libsasl2-dev \
        ca-certificates \
        bzip2 \
        libfontconfig \
    " \
    runtimeDeps=" \
        curl \
        git \
        unzip \
        libfreetype6-dev \
        libicu-dev \
        libjpeg-dev \
        libldap2-dev \
        libmemcachedutil2 \
        libpng-dev \
        libpq-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
    " \
    && apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y $buildDeps $runtimeDeps \
    && docker-php-ext-install bcmath bz2 calendar iconv intl mbstring mysqli opcache pdo_mysql pdo_pgsql pgsql soap zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install ldap \
    && docker-php-ext-install exif \
    && docker-php-ext-install pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis.so \
    && apt-get purge -y --auto-remove $buildDeps \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && curl -fsSL https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require phpunit/phpunit ^9.0 --no-progress --no-scripts --no-interaction \
    && rm -r /var/lib/apt/lists/*

RUN curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar && \
    mv phpcs.phar /usr/local/bin/phpcs && \
    chmod +x /usr/local/bin/phpcs

COPY opcache.ini /usr/local/etc/php/conf.d/

RUN set -x  \
    # Install official PhantomJS release
 && mkdir /tmp/phantomjs \
 && curl -Ls https://bitbucket.org/ariya/phantomjs/downloads/phantomjs-2.1.1-linux-x86_64.tar.bz2 \
        | tar -xj --strip-components=1 -C /tmp/phantomjs \
 && mv /tmp/phantomjs/bin/phantomjs /usr/local/bin

ARG UID
ARG GID

RUN usermod -u ${UID} www-data
RUN groupmod -g ${GID} www-data

USER www-data