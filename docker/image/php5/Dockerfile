FROM coal/baseimage

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
	apt-get install -y \
	php5 \
	php5-apcu \
	php5-cli \
	php5-curl \
	php5-fpm \
	php5-json \
	php5-mysql
RUN apt-get clean

EXPOSE 9000

RUN ln -sf /dev/stderr /var/log/php-fpm.log

CMD php5-fpm
