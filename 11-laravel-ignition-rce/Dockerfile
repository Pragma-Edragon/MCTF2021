FROM php:8.0.1-apache

# 2. Apache configs + document root.
RUN echo "ServerName laravel-app.local" >> /etc/apache2/apache2.conf
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV SOURCE_ROOT=/var/www/html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

# 4. Start with base PHP config, then add extensions.
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# 5. Users and rights
RUN useradd -u 1001 -G www-data -d /home/devuser devuser -s /bin/bash
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

COPY laravel-app /var/www/html

WORKDIR /var/www/html

# 6. Dependency
RUN apt-get update && apt-get install -y libpq-dev git && docker-php-ext-install pdo pdo_pgsql

# Installing composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN echo 'phar.readonly=0' >> /usr/local/etc/php/conf.d/docker-php-phar-readonly.ini

RUN composer install && composer update

RUN chown -R devuser:www-data "/var/www/html/storage/logs" && \
    chown -R devuser:www-data "/var/www/html/storage/framework"

RUN touch "/var/www/html/database/database.sqlite"
RUN chown -R devuser:www-data "/var/www/html/database/"

USER devuser
ENTRYPOINT ["/var/www/html/entrypoint.sh"]
