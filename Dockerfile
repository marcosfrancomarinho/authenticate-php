# Usa a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Define o diretório de trabalho
WORKDIR /var/www/html

# Instala extensões necessárias (PDO para PostgreSQL)
RUN apt-get update && apt-get install -y libpq-dev \
   && docker-php-ext-install pdo pdo_pgsql

# Instala o Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definição de variáveis de ambiente

# Copia os arquivos do projeto para o container
COPY . .
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
# Expõe a porta 80
EXPOSE 80 
