FROM php:8.1-cli

RUN apt-get update && apt-get install -y libpq-dev libzip-dev unzip libpng-dev libonig-dev libxml2-dev default-mysql-client

RUN docker-php-ext-install pdo pdo_mysql

COPY . /app
WORKDIR /app

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "index.php"]
