FROM php:8.3-fpm-alpine

# Instalar dependências do sistema
RUN apk add --no-cache \
    bash \
    curl \
    git \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    libxml2-dev

# Extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        xml \
        opcache

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Usuário não-root
RUN addgroup -g 1000 www && adduser -u 1000 -G www -s /bin/bash -D www
USER www

EXPOSE 9000
CMD ["php-fpm"]
