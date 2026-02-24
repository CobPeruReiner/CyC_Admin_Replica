FROM php:5.6-apache

# usar repos archivados
RUN sed -i 's|deb.debian.org|archive.debian.org|g' /etc/apt/sources.list \
  && sed -i 's|security.debian.org|archive.debian.org|g' /etc/apt/sources.list \
  && sed -i '/stretch-updates/d' /etc/apt/sources.list

# permitir repos expirados
RUN echo 'Acquire::Check-Valid-Until "false";' > /etc/apt/apt.conf.d/99no-check-valid

# instalar SSL (fix GPG)
RUN apt-get update \
  && apt-get install -y --allow-unauthenticated ca-certificates openssl \
  && update-ca-certificates

# extensiones mysql legacy
RUN docker-php-ext-install mysql mysqli pdo pdo_mysql

# apache config
RUN a2enmod rewrite headers \
  && sed -ri 's/^ServerTokens .*/ServerTokens Prod/' /etc/apache2/conf-available/security.conf || true \
  && sed -ri 's/^ServerSignature .*/ServerSignature Off/' /etc/apache2/conf-available/security.conf || true

RUN printf "ServerName localhost\n" > /etc/apache2/conf-available/servername.conf \
  && a2enconf servername

# PHP config
ENV TZ=America/Lima

RUN mkdir -p /var/log/php \
  && touch /var/log/php/error.log \
  && { \
  echo "display_errors=Off"; \
  echo "log_errors=On"; \
  echo "error_log=/var/log/php/error.log"; \
  echo "date.timezone=America/Lima"; \
  echo "openssl.cafile=/etc/ssl/certs/ca-certificates.crt"; \
  } > /usr/local/etc/php/conf.d/zz-local.ini

# copiar app
COPY ./src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html