FROM php:8.3-fpm

COPY php.ini /usr/local/etc/php/
COPY docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY .bashrc /root/

# Paquetes del sistema + extensiones PHP necesarias para Laravel
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
    build-essential \
    zlib1g-dev \
    default-mysql-client \
    curl \
    gnupg \
    procps \
    vim \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install \
    zip \
    pdo_mysql \
    intl \
    gd \
    mbstring \
    bcmath \
    opcache \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Redis
RUN pecl install redis \
  && docker-php-ext-enable redis

# PCOV
RUN pecl install pcov \
  && docker-php-ext-enable pcov

# Node.js, NPM, Yarn
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
  && apt-get install -y nodejs \
  && npm install -g npm@10 \
  && npm install -g yarn \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php \
  && php -r "unlink('composer-setup.php');" \
  && mv composer.phar /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_HOME=/composer
ENV PATH="${PATH}:/composer/vendor/bin"

RUN composer config --global process-timeout 3600 \
  && composer global require "laravel/installer"

WORKDIR /root
RUN git clone https://github.com/seebi/dircolors-solarized

EXPOSE 5173

WORKDIR /var/www
RUN chown -R www-data:www-data /var/www
