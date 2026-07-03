FROM docker.io/node:24-alpine AS builder

WORKDIR /var/www/html

COPY app/package*.json .
RUN npm i

COPY app .
RUN npm run build

# -----------------------------------

FROM docker.io/nginx:1.30-alpine3.23

WORKDIR /var/www/html

COPY services/prod/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY services/prod/nginx/nginx.conf /etc/nginx/nginx.conf
COPY app .
COPY --from=builder /var/www/html/public/build public/build

RUN apk update && \
    apk add --no-cache vim bash && \
    echo "alias vi='vim'" >> /etc/profile && \
    adduser -D -u 82 www-data && \
    chown -R www-data:www-data .

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
