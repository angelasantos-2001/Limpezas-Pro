# Usa uma imagem PHP oficial
FROM php:8.2-cli

# Instala dependências do sistema
RUN apt-get update -y && apt-get install -y libpq-dev unzip

# Instala extensões PHP necessárias para Laravel e PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define a pasta de trabalho (onde o código vai viver dentro do container)
WORKDIR /app

# Copia todos os ficheiros do teu computador para a pasta /app do container
COPY . .

# Instala as dependências do Laravel
RUN composer install --optimize-autoloader --no-dev

# Dá as permissões necessárias às pastas do Laravel
RUN chmod -R 775 storage bootstrap/cache

# Comando para iniciar o servidor
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}