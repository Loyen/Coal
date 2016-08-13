FROM coal/baseimage

RUN apt-get update && \
	DEBIAN_FRONTEND=noninteractive && \
	apt-get install -y nginx && \
	apt-get clean

EXPOSE 80

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

CMD nginx
