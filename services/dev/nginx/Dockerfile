FROM docker.io/nginx:1.30-alpine3.23

WORKDIR /var/www/html

RUN apk update && \
    apk add bash vim && \
    echo "alias vi='vim'" >> /etc/profile

COPY services/dev/nginx/default.conf /etc/nginx/conf.d/default.conf

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
