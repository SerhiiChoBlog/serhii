FROM docker.io/nginx:1.30-alpine3.23

RUN apk update && apk upgrade

COPY default.conf /etc/nginx/sites-available/default.conf

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
