# Use uma imagem base do PHP-FPM
FROM php:8.3-fpm

# Instale as extensões necessárias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Defina o diretório de trabalho
WORKDIR /var/www

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Copie o código da aplicação para o contêiner
COPY . /var/www

# Defina permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Exponha a porta padrão do PHP-FPM
EXPOSE 9000
