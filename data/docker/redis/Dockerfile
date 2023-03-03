FROM redis:7.0

MAINTAINER Vitaliy Syrydov <svyrydov.vitaliy@gmail.com>

ARG HOST_UID=1000

RUN usermod -u ${HOST_UID} redis
RUN groupmod -g ${HOST_UID} redis
