FROM docker.io/nginx:1.30-alpine3.23

WORKDIR /var/www/html

RUN apk update && \
    apk add bash vim && \
    echo "alias vi='vim'" >> /etc/profile

COPY services/shared/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

RUN apk update && \
    apk add --no-cache vim bash shadow && \
    echo "alias vi='vim'" >> /etc/profile && \
    usermod -u 82 nginx

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
