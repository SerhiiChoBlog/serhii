FROM docker.io/redis:8.8-alpine

RUN apk update && \
    apk add --no-cache \
        vim \
        bash && \
    echo 'alias ll="ls -hlaF"' >> ~/.bashrc && \
    echo 'alias vi="vim"' >> ~/.bashrc

COPY services/prod/redis/redis.conf /usr/local/etc/redis/redis.conf

CMD [ "redis-server", "/usr/local/etc/redis/redis.conf" ]
