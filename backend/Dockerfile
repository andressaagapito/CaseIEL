FROM php:8.2-cli-bookworm

# Dependências básicas
RUN apt-get update && apt-get install -y \
    gnupg \
    curl \
    git \
    unzip \
    zip \
    libzip-dev \
    unixodbc \
    unixodbc-dev \
    && rm -rf /var/lib/apt/lists/*

# Microsoft SQL Server ODBC Driver 18 (Debian 12)
RUN curl -fsSL https://packages.microsoft.com/keys/microsoft.asc \
    | gpg --dearmor \
    -o /usr/share/keyrings/microsoft-prod.gpg

RUN echo "deb [arch=amd64 signed-by=/usr/share/keyrings/microsoft-prod.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" \
    > /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 \
    && rm -rf /var/lib/apt/lists/*

# Extensões SQL Server para PHP 8.2
RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv

# Extensão zip
RUN docker-php-ext-install zip

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Dependências PHP
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

# Render fornece a variável PORT automaticamente
CMD php -S 0.0.0.0:$PORT -t public