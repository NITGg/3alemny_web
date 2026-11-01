# Moodle 4.5 يدعم PHP من 8.1 حتى 8.3؛ 8.3.36+ فيه إصلاح ثغرات أكتوبر 2026.
FROM php:8.3-apache

# مكتبات النظام المطلوبة لبناء امتدادات PHP التي يحتاجها Moodle.
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libcurl4-openssl-dev \
    libfreetype6-dev \
    libicu-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    libsodium-dev \
    libldap2-dev \
    libxslt1-dev \
    libpq-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# إعداد GD لدعم الصور.
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg

# إعداد LDAP.
RUN docker-php-ext-configure ldap

# امتدادات PHP المطلوبة/الموصى بها لـ Moodle.
RUN docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo \
    pdo_mysql \
    intl \
    gd \
    soap \
    exif \
    zip \
    mbstring \
    opcache \
    sodium \
    ldap \
    xsl \
    bcmath

# تفعيل وحدات Apache المطلوبة.
RUN a2enmod rewrite headers expires

# إعدادات PHP المخصّصة لـ Moodle (max_input_vars وغيرها).
COPY php-moodle.ini /usr/local/etc/php/conf.d/php-moodle.ini

# مجلد العمل داخل الـ Container.
WORKDIR /var/www/html
