# Usar uma imagem oficial PHP com Apache
FROM php:8.1-apache

# Instalar dependências necessárias para o Composer, PDO e PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libpq-dev

# Instalar a extensão GD e configurar as dependências corretamente
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype2 --with-jpeg-dir=/usr/include && \
    docker-php-ext-install gd pdo pdo_pgsql

# Baixar e instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto para o contêiner
COPY . /var/www/html

# Expor a porta 80 para acessar o servidor Apache
EXPOSE 80

# Instalar as dependências do Composer
RUN composer install

# Configurar o Apache para usar o diretório de trabalho
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Comando para rodar o Apache em primeiro plano
CMD ["apache2-foreground"]
