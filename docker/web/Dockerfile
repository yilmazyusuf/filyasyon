ARG DOCKER_WEB
FROM ${DOCKER_WEB}

LABEL maintainer="Yusuf <y.yilmaz@hotmail.com.tr>"

ARG DOCKER_DOCUMENT_PATH
RUN mkdir -p ${DOCKER_DOCUMENT_PATH}
WORKDIR ${DOCKER_DOCUMENT_PATH}

RUN apt-get update && apt-get install -y \
    git \
    libzip-dev \
    zip \
    sudo \
	cron \
    nano \
    ssh \
    nfs-common \
    cifs-utils \
    iputils-ping \
    certbot \
    python3-certbot-apache \
    libfreetype6-dev \
            libjpeg62-turbo-dev \
            libpng-dev \
        && docker-php-ext-configure gd \
            --with-freetype-dir=/usr/include/ \
            --with-jpeg-dir=/usr/include/ \
        && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install \
    bcmath \
    mysqli \
    pdo_mysql \
    zip

COPY ./cronjobs/laravel /etc/cron.d/laravel
RUN chmod 0644 /etc/cron.d/laravel
RUN crontab /etc/cron.d/laravel


COPY ./apache2.conf /etc/apache2/apache2.conf
COPY ./000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY ./security.conf /etc/apache2/conf-available/security.conf
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN chown -R www-data:www-data /var/www
RUN echo "Europe/Istanbul" > /etc/timezone && rm /etc/localtime && dpkg-reconfigure -f noninteractive tzdata

RUN apt-get update && \
    apt-get install -y \
        locales && \
    rm -r /var/lib/apt/lists/*


RUN sed -i -e 's/# tr_TR.UTF-8 UTF-8/tr_TR.UTF-8 UTF-8/' /etc/locale.gen && \
    dpkg-reconfigure --frontend=noninteractive locales

RUN a2enmod rewrite
RUN service apache2 restart


ENTRYPOINT [ "sh", "-c", "service cron restart && apache2-foreground"]