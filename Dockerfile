FROM php:5.6-apache

# Instalar certificados SSL (IMPORTANTE para SMTP y reCAPTCHA)
RUN apt-get update && apt-get install -y \
  ca-certificates \
  openssl \
  && update-ca-certificates

# Extensiones que requiere tu proyecto (incluye ext/mysql LEGACY)
RUN docker-php-ext-install mysql mysqli pdo pdo_mysql

# Apache hardening
RUN a2enmod rewrite headers \
  && sed -ri 's/^ServerTokens .*/ServerTokens Prod/' /etc/apache2/conf-available/security.conf || true \
  && sed -ri 's/^ServerSignature .*/ServerSignature Off/' /etc/apache2/conf-available/security.conf || true

# Evitar warning ServerName
RUN printf "ServerName localhost\n" > /etc/apache2/conf-available/servername.conf \
  && a2enconf servername

# Configuración PHP
ENV TZ=America/Lima

RUN mkdir -p /var/log/php \
  && touch /var/log/php/error.log \
  && { \
  echo "display_errors=Off"; \
  echo "log_errors=On"; \
  echo "error_log=/var/log/php/error.log"; \
  echo "date.timezone=America/Lima"; \
  echo "openssl.cafile=/etc/ssl/certs/ca-certificates.crt"; \
  echo "openssl.capath=/etc/ssl/certs"; \
  } > /usr/local/etc/php/conf.d/zz-local.ini

# Copiar tu aplicación
COPY ./src/ /var/www/html/

# Permisos
RUN chown -R www-data:www-data /var/www/html