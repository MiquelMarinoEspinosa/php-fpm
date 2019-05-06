FROM nginx:latest

ADD conf/nginx.conf /etc/nginx
ADD conf/sites-enabled/site.conf /etc/nginx/sites-enabled/site.conf
ADD conf/certs/ssl.crt /etc/nginx
ADD conf/certs/ssl.key /etc/nginx
RUN mkdir -p /var/www

WORKDIR /var/www/

EXPOSE 443