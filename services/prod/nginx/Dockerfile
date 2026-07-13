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
    apk add --no-cache vim bash shadow && \
    echo "alias vi='vim'" >> ~/.bashrc && \
    echo "alias ll='ls -hlaF'" >> ~/.bashrc && \
    usermod -u 82 nginx && \
    chown -R nginx:nginx . && \
    ln -s /var/www/html/storage/app/public /var/www/html/public/storage

CMD [ "/usr/sbin/nginx", "-g", "daemon off;" ]
