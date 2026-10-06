FROM php:8.4-apache

RUN docker-php-ext-install pdo_mysql \
    && a2enmod rewrite headers

WORKDIR /var/www/html
COPY . /var/www/html/

RUN mkdir -p uploads/products uploads/kits uploads/testimonials \
    && chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 755 /var/www/html/uploads

# Do not expose PHP execution inside user-upload directories.
RUN printf '%s\n' \
    '# Disable PHP execution in uploads' \
    'php_flag engine off' \
    'RemoveHandler .php .phtml .php3 .php4 .php5 .php7 .php8 .phar' \
    'RemoveType .php .phtml .php3 .php4 .php5 .php7 .php8 .phar' \
    'Options -ExecCGI' \
    > /var/www/html/uploads/.htaccess \
    && chown www-data:www-data /var/www/html/uploads/.htaccess

EXPOSE 80
CMD ["apache2-foreground"]
