FROM coal/baseimage

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
	apt-get install -y mariadb-server && \
	apt-get clean

EXPOSE 3306

CMD mysqld
