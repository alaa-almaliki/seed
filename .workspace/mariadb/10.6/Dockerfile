FROM mariadb:10.6

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update -y

RUN apt-get install -y software-properties-common \
    git \
    vim \
    curl \
    zip \
    unzip

RUN apt-get install -y php-cli \
    php-mysql

########### Install Composer #################
RUN curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html