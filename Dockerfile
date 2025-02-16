# Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala dependências do sistema necessárias para extensões do PHP
RUN apt-get update && apt-get install -y \
   libpq-dev unzip curl git \
   && docker-php-ext-install pdo pdo_pgsql \
   && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala o Composer de maneira mais segura
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copia apenas os arquivos necessários primeiro para otimizar o cache
COPY composer.json composer.lock ./

# Instala dependências do Composer antes de copiar todo o código-fonte
RUN composer install --no-dev --no-interaction --prefer-dist

# Copia todo o código do projeto para dentro do container
COPY . .

# Corrige permissões para evitar problemas com usuário www-data
RUN chown -R www-data:www-data /var/www/html \
   && chmod -R 755 /var/www/html

# Define o ServerName no Apache para evitar warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expõe a porta 80
EXPOSE 80

# Comando padrão para iniciar o Apache no modo foreground
CMD ["apache2-foreground"]
