FROM nginx:latest

LABEL maintainer="josh@osodevops.io"

ARG BUILD_DATE

LABEL org.label-schema.build-date=$BUILD_DATE

COPY . /var/www/html

COPY ./docker/app/nginx/configs/nginx.conf /etc/nginx/conf.d/default.conf

# Create Storage Link (php artisan storage:link)
RUN rm -rf /var/www/html/public/storage
RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage
