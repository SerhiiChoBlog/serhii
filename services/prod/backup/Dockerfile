FROM docker.io/alpine:3.24

WORKDIR /app

RUN apk update && \
    apk add --no-cache \
        bash \
        vim \
        tzdata \
        mariadb-client && \
    echo "alias vi='vim'" >> ~/.bashrc && \
    echo "alias ll='ls -hlaF'" >> ~/.bashrc

COPY services/prod/backup/cron-script /app/

# Install supercronic for Cron Jobs
RUN wget -qO /usr/local/bin/supercronic https://github.com/aptible/supercronic/releases/latest/download/supercronic-linux-amd64 && \
    chmod +x /usr/local/bin/supercronic

RUN echo "0 0,12 * * * /app/cron-script" > /app/crontab

CMD ["supercronic", "/app/crontab"]
