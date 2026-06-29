FROM docker.io/node:24-alpine AS builder

WORKDIR /var/www/html

COPY app/package*.json .
RUN npm i

COPY app .
RUN npm run build

# -----------------------------------

FROM docker.io/nginx:1.30-alpine3.23

WORKDIR /var/www/html

COPY services/prod/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY app .
COPY --from=builder /var/www/html/public/build public/build

RUN chown -R nginx:nginx .

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]
