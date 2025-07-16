FROM php:8.3-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ARG password

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql
# Install PHP extensions
#RUN docker-php-ext-install mbstring exif pcntl bcmath gd
RUN pecl update-channels

COPY ./.docker/php /usr/local/etc/php

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www/html

RUN apt-get -y update && \
	apt-get -y install git

#install RSA key for git
RUN mkdir /root/.ssh/
ADD ./.docker/.ssh/id_rsa /root/.ssh/id_rsa
ADD ./.docker/.ssh/id_rsa.pub /root/.ssh/id_rsa.pub
RUN chmod 600 /root/.ssh/id_rsa
RUN chmod 600 /root/.ssh/id_rsa.pub
RUN eval `ssh-agent -s` && \
    ssh-add /root/.ssh/id_rsa

# Create known_hosts
RUN touch /root/.ssh/known_host
# Add gitlab key
RUN ssh-keyscan gitlab.com >> /root/.ssh/known_hosts

#for user `git` add key:
RUN mkdir /home/git/.ssh/
ADD ./.docker/.ssh/id_rsa /home/git/.ssh/id_rsa
ADD ./.docker/.ssh/config /home/git/.ssh/config
ADD ./.docker/.ssh/id_rsa.pub /home/git/.ssh/id_rsa.pub
RUN chmod 600 /home/git/.ssh/id_rsa
RUN chmod 600 /home/git/.ssh/id_rsa.pub
RUN eval `ssh-agent -s` && \
    ssh-add /home/git/.ssh/id_rsa

# Create known_hosts
RUN touch /home/git/.ssh/known_host
# Add gitlab key
RUN ssh-keyscan github.com >> /home/git/.ssh/known_hosts

# Clone the conf files into the docker container
RUN git clone https://github.com/sneef/ecommpay.git ./ && \
    chmod g+w .git -R

RUN	usermod -aG root $user

RUN git config --global --add safe.directory /var/www/html

RUN usermod -aG sudo git

RUN git config --global http.sslVerify false

USER root
