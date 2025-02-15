# Usar uma imagem oficial PHP com Apache
FROM php:8.1-apache

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Copiar os arquivos do seu projeto para o contêiner
COPY . /var/www/html/

# Expor a porta 80
EXPOSE 80

# Iniciar o Apache
CMD ["apache2-foreground"]
