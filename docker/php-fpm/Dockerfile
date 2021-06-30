FROM php:8.0-fpm
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN printf '[PHP]\ndate.timezone = "Europe/London"\n' > /usr/local/etc/php/conf.d/tzone.ini

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y install \
    apt-transport-https \
    wget \
    gnupg \
    libssh2-1 \
    libssh2-1-dev \
    locales \
    libonig-dev \
    libxml2-dev \
    unzip \
    zlib1g-dev \
    libxml2-dev \
    libpng-dev \
    libicu-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    libzip-dev \
    libfontconfig1 \
    libxrender1 \
    libxtst6 \
    libxi6 \
    git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install selected php extensions
RUN docker-php-ext-install -j$(nproc) zip \
        pdo \
        pdo_mysql \
        mbstring \
        xml \
        intl

RUN echo "en_GB.UTF-8 UTF-8" >> /etc/locale.gen
RUN locale-gen
RUN ln -s $(which php) /usr/bin/php8.0

# Install composer
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/usr/local/bin --filename=composer --2
