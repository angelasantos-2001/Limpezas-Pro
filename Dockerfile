FROM php:8.2-cli

# Instalar dependências para o Laravel e para a tua base de dados PostgreSQL
RUN apt-get update -y && apt-get install -y libpq-dev unzip \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar o Composer (que estava a dar erro na tua imagem)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir a pasta do projeto
WORKDIR /app

# Copiar os teus ficheiros todos
COPY . .

# Instalar o Laravel
RUN composer install --optimize-autoloader --no-dev

# Dar permissões às pastas que o Laravel precisa
RUN chmod -R 775 storage bootstrap/cache

# Comando para ligar o teu site
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}