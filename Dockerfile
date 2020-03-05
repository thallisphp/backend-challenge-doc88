# Imagem base com PHP 7.4, xdebug e extensões requeridas pelo Laravel
FROM thallisphp/php:cli-xdebug

LABEL maintainer="ThallisPHP <thallisphp@gmail.com>"

# Configuração de usuário para não utilizar o root
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN apk add --no-cache bash

RUN groupmod -o -g ${PGID} www-data && \
    usermod  -o -u ${PUID} -g www-data www-data

# php.ini ajustado para o Laravel
COPY ./docker/laravel.ini /usr/local/etc/php/conf.d

WORKDIR /var/www/html

# Instalação do PHPUnit
RUN wget -O /usr/bin/phpunit https://phar.phpunit.de/phpunit-8.phar && \
    chmod +x /usr/bin/phpunit

# Instalação do Composer
RUN apk add --no-cache \
    nano \
    shadow \
    git \
    zip \
    && rm -rf /tmp/*

WORKDIR /var

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer global require hirak/prestissimo --no-plugins --no-scripts \
    && composer --version

USER www-data

WORKDIR /var/www/html

# Envio dos arquivos para a imagem
COPY --chown=www-data:www-data ./ /var/www/html
COPY --chown=www-data:www-data ./.env.example /var/www/html/.env

RUN composer install --prefer-dist --no-suggest --no-interaction
RUN php artisan key:generate
RUN php artisan migrate

CMD ["php", "artisan", "serve"]
