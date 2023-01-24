FROM php:fpm-stretch

RUN apt-get update && apt-get upgrade -y

RUN apt-get update && apt-get install -y --no-install-recommends \
      git \
      zlib1g-dev \
      libxml2-dev \
      libzip-dev \
      && docker-php-ext-install \
      zip \
      intl \
      mysqli \
      pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN mkdir /usr/local/nvm
ENV NVM_DIR /usr/local/nvm
ENV NODE_VERSION 16.14.2
ENV NVM_INSTALL_PATH $NVM_DIR/versions/node/v$NODE_VERSION
RUN rm /bin/sh && ln -s /bin/bash /bin/sh
RUN curl --silent -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash
RUN source $NVM_DIR/nvm.sh \
      && nvm install $NODE_VERSION \
      && nvm alias default $NODE_VERSION \
      && nvm use default
ENV NODE_PATH $NVM_INSTALL_PATH/lib/node_modules
ENV PATH $NVM_INSTALL_PATH/bin:$PATH

COPY symfony/ /var/www/symfony

WORKDIR /var/www/symfony/
