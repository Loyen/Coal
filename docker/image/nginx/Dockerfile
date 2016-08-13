FROM coal/baseimage

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
	apt-get install -y nginx && \
	apt-get clean

EXPOSE 80

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

CMD nginx
