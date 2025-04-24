# Usa imagem oficial do PHP 8.1 com Apache
FROM php:8.1-apache

# Instala extensões do PHP necessárias (incluindo PostgreSQL)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    zip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Ativa mod_rewrite do Apache (útil para MVC/URLs amigáveis)
RUN a2enmod rewrite

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos da aplicação para dentro do container
COPY . /var/www/html

# Permissões
RUN chown -R www-data:www-data /var/www/html

# Exposição da porta padrão do Apache
EXPOSE 80
