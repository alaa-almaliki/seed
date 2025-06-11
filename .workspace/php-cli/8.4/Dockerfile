FROM php:8.4-cli

RUN groupadd -r mysql && useradd -r -g mysql mysql

ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt-get install -y git \
    vim \
    zip \
    unzip



########### Install Composer #################
RUN curl -sS https://getcomposer.org/installer | \
  php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/lib/mysql \
    /run/mysqld \
    && chown -R mysql:mysql /var/lib/mysql \
    /run/mysqld

RUN touch /run/mysqld/mysqld.sock && chown mysql:mysql /run/mysqld/mysqld.sock

RUN apt-get install -y mariadb-server

COPY mariadb/10.11/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf

WORKDIR /var/www/html

USER mysql
EXPOSE 3306
CMD ["mysqld"]
