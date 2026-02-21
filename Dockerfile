FROM php:5.6-apache

# Extensiones que requiere tu proyecto (incluye ext/mysql LEGACY)
RUN docker-php-ext-install mysql mysqli pdo pdo_mysql

# Apache
RUN a2enmod rewrite headers \
  && sed -ri 's/^ServerTokens .*/ServerTokens Prod/' /etc/apache2/conf-available/security.conf || true \
  && sed -ri 's/^ServerSignature .*/ServerSignature Off/' /etc/apache2/conf-available/security.conf || true

# Evitar warning "Could not reliably determine the server's fully qualified domain name"
RUN printf "ServerName localhost\n" > /etc/apache2/conf-available/servername.conf \
  && a2enconf servername

# Zona horaria solo para PHP (no instala tzdata)
ENV TZ=America/Lima
RUN bash -lc 'mkdir -p /var/log/php && touch /var/log/php/error.log \
  && { \
  echo "display_errors=Off"; \
  echo "log_errors=On"; \
  echo "error_log=/var/log/php/error.log"; \
  echo "date.timezone=America/Lima"; \
  } > /usr/local/etc/php/conf.d/zz-local.ini'

# Tu app
COPY ./src/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html
