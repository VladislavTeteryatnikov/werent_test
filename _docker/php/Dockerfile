# Образ
FROM php:8.2-cli-alpine

# Установка расширений
RUN apk add --no-cache \
    curl \
    libzip-dev \
    zip \
    autoconf \
    g++ \
    make \
    pcre-dev

# Установка PHP-расширения redis через PECL
RUN pecl install redis-5.3.7 && \
    docker-php-ext-enable redis

# Рабочая директория
WORKDIR /app

# Не даем падать контейнеру
CMD ["tail", "-f", "/dev/null"]