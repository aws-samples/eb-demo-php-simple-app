FROM ubuntu:12.04

# Install dependencies
RUN apt-get update -y
RUN apt-get install -y curl apache2 php5 libapache2-mod-php5 php5-mcrypt

# Install composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer

# Install app
RUN rm -rf /var/www/*
ADD . /var/www
RUN  cd /var/www && /usr/bin/composer install

# Configure logging
ENV APACHE_LOG_DIR /var/log/apache2

EXPOSE 80

ENTRYPOINT ["/usr/sbin/apache2", "-D",  "FOREGROUND"]