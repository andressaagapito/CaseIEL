FROM php:8.2-fpm

# Instalar dependências do sistema e ferramentas
RUN apt-get update && apt-get install -y \
    gnupg2 \
    apt-transport-https \
    unixodbc-dev \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    curl

# Instalar o Microsoft ODBC Driver 18 para SQL Server
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - \
    && curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 \
    && echo 'export PATH="$PATH:/opt/mssql-tools18/bin"' >> ~/.bashrc

# Instalar extensões do PHP para SQL Server e utilitários
RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && docker-php-ext-install zip

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/backend
