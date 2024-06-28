ARG  PHP_VERSION=8.2
FROM shinsenter/slim:php${PHP_VERSION}

# ==========================================================

# you may want to install some PHP modules
# e.g: the following line will install imagick, pgsql, solr modules
RUN phpaddmod xdebug
#COPY php/docker-php-ext-xdebug.ini /etc/php/${PHP_VERSION}/cli/conf.d/
#COPY php/docker-php-ext-xdebug.ini /etc/php/${PHP_VERSION}/fpm/conf.d/
COPY php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d

RUN apt-get update && apt-get install -y vim
# ==========================================================

# Control your timezone
ENV TZ="UTC"

# sets GID and UID
ENV PUID=9999
ENV PGID=9999

# sets web server root path
ENV WEBHOME="/var/www/html"

# ==========================================================

# You can easily change PHP-FPM configurations
# by using pre-defined Docker's environment variables.
# Learn more: https://code.shin.company/php#customize-docker-imag