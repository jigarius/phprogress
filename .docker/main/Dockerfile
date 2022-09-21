FROM php:8.0-alpine

WORKDIR /app

ENV PATH="/app/bin:/app/vendor/bin:${PATH}"

RUN apk add git

COPY ./.docker/main/install-composer.sh /tmp/
RUN /tmp/install-composer.sh

CMD ["tail", "-f", "/dev/null"]
