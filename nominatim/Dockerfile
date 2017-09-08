FROM ubuntu:xenial
MAINTAINER Nicolas Ternisien <nicolas.ternisien@gmail.com>

EXPOSE 80

ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    cmake \
    g++ \
    libboost-dev  \
    libboost-system-dev \
    libboost-filesystem-dev  \
    libexpat1-dev  \
    zlib1g-dev  \
    libxml2-dev \
    libbz2-dev  \
    libpq-dev  \
    libgeos-dev  \
    libgeos++-dev  \
    libproj-dev \
    apache2  \
    php  \
    php-pgsql  \
    libapache2-mod-php  \
    php-pear  \
    php-db \
    php-intl  \
    git \
    ca-certificates \
    curl \
    postgresql-client \
    postgresql-server-dev-9.5 \
    proj-bin \
    && rm -rf /var/lib/apt/lists/*

# Install gosu
ENV GOSU_VERSION 1.9
RUN set -x \
    && dpkgArch="$(dpkg --print-architecture | awk -F- '{ print $NF }')" \
    && curl -L -o /usr/local/bin/gosu "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$dpkgArch" \
    && curl -L -o /usr/local/bin/gosu.asc "https://github.com/tianon/gosu/releases/download/$GOSU_VERSION/gosu-$dpkgArch.asc" \
    && export GNUPGHOME="$(mktemp -d)" \
    && gpg --keyserver ha.pool.sks-keyservers.net --recv-keys B42F6819007F00F88E364FD4036A9C25BF357DD4 \
    && gpg --batch --verify /usr/local/bin/gosu.asc /usr/local/bin/gosu \
    && rm -r "$GNUPGHOME" /usr/local/bin/gosu.asc \
    && chmod +x /usr/local/bin/gosu \
    && gosu nobody true

ARG WEBROOT=/var/www/html/nominatim
ARG NOMINATIM_HOME=/app
RUN groupadd -r nominatim && useradd -d ${NOMINATIM_HOME}  -s /bin/bash -r -g nominatim nominatim
RUN mkdir -p ${WEBROOT} ${NOMINATIM_HOME} && chmod -R 755 ${WEBROOT} ${NOMINATIM_HOME} && chown -R nominatim:nominatim ${WEBROOT} ${NOMINATIM_HOME}

WORKDIR ${NOMINATIM_HOME}
ARG NOMINATIM_VERSION=3.0.1
ARG NOMINATIM_SHA256=30c19ba03bae0b23bd789758e41849da65b5a2104e69f072d4c754cb9b509c57
RUN gosu nominatim curl -o nominatim.tar.bz2 http://www.nominatim.org/release/Nominatim-${NOMINATIM_VERSION}.tar.bz2 \
  && echo "${NOMINATIM_SHA256} nominatim.tar.bz2" | sha256sum -c \
  && gosu nominatim tar -xf nominatim.tar.bz2 --strip-components=1 \
  && rm *.tar.bz2

RUN gosu nominatim mkdir build \
    && cd build \
    && cmake .. \
    && make

COPY entrypoint.sh wait-for-it.sh ./
COPY local.php ${NOMINATIM_HOME}/build/settings/local.php
COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY apache2-foreground /usr/local/bin

VOLUME /importdata

CMD /app/entrypoint.sh
