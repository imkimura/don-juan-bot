FROM php:8.1-alpine

ARG COMPOSER_BIN=/usr/bin/composer
ARG COMPOSER_VERSION=2.2.12
ARG COMPOSER_SHA256SUM=1ce90687eb3f89a99c059d45dd419d08430ed249468544b932b1dad7fb22dda0

RUN set -ex ;\
  wget -O "$COMPOSER_BIN" "https://getcomposer.org/download/$COMPOSER_VERSION/composer.phar" ;\
  printf "%s  %s\n" "$COMPOSER_SHA256SUM" "$COMPOSER_BIN" | sha256sum -c - ;\
  chmod +x -- "$COMPOSER_BIN" ;\
  composer --version ;\
  composer diagnose || printf 'composer diagnose exited: %d\n' $? ;\
  :