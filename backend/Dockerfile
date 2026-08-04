FROM php:8.2-cli-bookworm

# Instalar dependências básicas
RUN apt-get update && apt-get install -y \
    gnupg2 \
    apt-transport-https \
    curl \
    git \
    unzip \
    libzip-dev \
    unixodbc \
    unixodbc-dev

# Adicionar repositório oficial da Microsoft para Debian 12 (Bookworm)
RUN curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg \
    && curl -fsSL https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list

# Instalar Microsoft ODBC Driver 18 para SQL Server
RUN apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18

# Instalar extensões do PHP para SQL Server via PECL
RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && docker-php-ext-install zip

# Instalar o Composer nativamente no container
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /app

# Copiar todos os arquivos da pasta backend para dentro do container
COPY . /app/

# Instalar as dependências do Composer para produção de forma isolada
RUN composer install --no-dev --optimize-autoloader

# Expor uma porta padrão (o Render informará a porta via variável de ambiente $PORT)
EXPOSE 8000

# Iniciar o servidor embutido do PHP
# O Render injeta automaticamente a variável $PORT. Caso falhe, usa 8000.
CMD php -S 0.0.0.0:${PORT:-8000} -t public
