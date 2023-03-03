FROM mariadb:10.6

MAINTAINER Vitaliy Syrydov <svyrydov.vitaliy@gmail.com>

ARG HOST_UID=1000

VOLUME ["/var/lib/mysql"]

RUN usermod -u ${HOST_UID} mysql

EXPOSE 3306
