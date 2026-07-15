FROM docker.io/redis:8.8-alpine

RUN apk update && \
    apk add --no-cache bash && \
    echo 'alias ll="ls -hlaF"' >> ~/.bashrc

COPY services/prod/redis/redis.conf /usr/local/etc/redis/redis.conf

CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]
