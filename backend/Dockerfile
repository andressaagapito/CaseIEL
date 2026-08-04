FROM php:8.2-cli-bookworm

# Instalar dependências básicas exigidas
RUN apt-get update && apt-get install -y \
    curl \
    gnupg \
    unzip \
    git \
    zip \
    libzip-dev \
    unixodbc \
    unixodbc-dev

# Adicionar repositório oficial da Microsoft explicitamente para Debian 12
RUN curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg \
    && curl -fsSL https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list

# Instalar Microsoft ODBC Driver 18 para SQL Server
RUN apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18

# Instalar extensões do PHP compatíveis com PHP 8.2 e habilitá-las
RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && docker-php-ext-install zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho esperado
WORKDIR /var/www/html

# Copiar código do backend
COPY . /var/www/html/

# Executar instalação de dependências de produção
RUN composer install --no-dev --optimize-autoloader

# Iniciar o servidor embutido do PHP usando a variável $PORT injetada pelo Render
CMD php -S 0.0.0.0:$PORT -t public
