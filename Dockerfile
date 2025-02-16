# Usando uma imagem base do PHP com Apache
FROM php:8.1-apache

# Instalar as dependências para PDO, PDO PostgreSQL e Slim
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libxml2-dev \
    php-xml \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar o código do projeto para o contêiner
COPY . .

# Instalar as dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Ativar o mod_rewrite do Apache (necessário para o Slim)
RUN a2enmod rewrite

# Expôr a porta do Apache
EXPOSE 80

# Iniciar o servidor Apache
CMD ["apache2-foreground"]