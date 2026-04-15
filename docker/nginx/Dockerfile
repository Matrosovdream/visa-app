FROM visa-app/php:prod AS appsrc

FROM nginx:1.27-alpine
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=appsrc /var/www/html/public /var/www/html/public
