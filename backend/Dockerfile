FROM php:8.2-apache

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Instalar dependências básicas
RUN apt-get update && apt-get install -y \
    gnupg2 \
    apt-transport-https \
    curl \
    git \
    unzip \
    libzip-dev \
    zip

# Instalar repositório oficial Microsoft e dependências do SQL Server
RUN curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg \
    && export DEBIAN_VERSION=$(. /etc/os-release && echo $VERSION_ID) \
    && curl -fsSL https://packages.microsoft.com/config/debian/$DEBIAN_VERSION/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18 unixodbc unixodbc-dev

# Instalar extensões PHP via pecl e habilitá-las
RUN pecl install sqlsrv pdo_sqlsrv \
    && docker-php-ext-enable sqlsrv pdo_sqlsrv \
    && docker-php-ext-install zip

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar o DocumentRoot do Apache para a pasta 'public'
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copiar os arquivos do backend para o container
WORKDIR /var/www/html
COPY . /var/www/html/

# Instalar as dependências do Composer para produção (não dependendo do local)
RUN composer install --no-dev --optimize-autoloader

# Ajustar permissões (opcional, dependendo de como o app usa arquivos)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
