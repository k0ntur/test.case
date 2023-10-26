#базовый образ(image) на базе которого будет создан образ для нашего приложения, берем с https://hub.docker.com/_/php
FROM php:8.2-fpm

#параметры компиляции(--build-param=) юзер / группа
ARG user

#устанавливаем sudo чтобы docker работал из под обычного пользователя но в случае чего была возможность выполнять действия от root
#устанавливаем ряд полезных приложений
RUN apt-get update && apt-get -y install  \
    sudo \
    git  \
    nano \
    wget \
    zip \
    unzip

RUN useradd -G users,www-data,root -d /home/$user $user
RUN mkdir -p /home/$user/.composer
RUN chown -R $user:$user /home/$user

#необходимо добавить пользователя в группу sudo
RUN usermod -aG sudo $user
#чтобы при использовании sudo не спрашивал пароль
RUN echo "$user ALL=(ALL) NOPASSWD: ALL" > /etc/sudoers

#install PHP libs' stage
RUN apt-get update && apt-get -y install libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN pecl install xdebug && docker-php-ext-enable xdebug

#устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#устанавливаем Symfony binary
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

#очищаем кеш apt
RUN apt-get clean all
RUN rm -rf /var/lib/apt/lists/*

#переключаемся на пользователя под которым будет работать container
USER $user