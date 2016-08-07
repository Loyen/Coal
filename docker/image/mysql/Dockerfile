FROM coal/baseimage

RUN apt-get update && \
	DEBIAN_FRONTEND=noninteractive && \
	apt-get install -y mariadb-server && \
	apt-get clean

EXPOSE 3306

CMD mysqld
