<<<<<<< HEAD
FROM composer:latest as setup

RUN mkdir /guzzle

WORKDIR /guzzle

RUN set -xe \
    && composer init --name=guzzlehttp/test --description="Simple project for testing Guzzle scripts" --author="Márk Sági-Kazár <mark.sagikazar@gmail.com>" --no-interaction \
    && composer require guzzlehttp/guzzle


FROM php:7.3

RUN mkdir /guzzle

WORKDIR /guzzle

COPY --from=setup /guzzle /guzzle
=======
FROM composer:latest as setup

RUN mkdir /guzzle

WORKDIR /guzzle

RUN set -xe \
    && composer init --name=guzzlehttp/test --description="Simple project for testing Guzzle scripts" --author="Márk Sági-Kazár <mark.sagikazar@gmail.com>" --no-interaction \
    && composer require guzzlehttp/guzzle


FROM php:7.3

RUN mkdir /guzzle

WORKDIR /guzzle

COPY --from=setup /guzzle /guzzle
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
