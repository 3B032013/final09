 FROM php:8.2-fpm

 RUN apt-get update && apt-get install -y nginx zip unzip git

 WORKDIR /var/www

 COPY . /var/www

 COPY ./nginx/default /etc/nginx/sites-available/default

 RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

 RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
 RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
 RUN composer install --prefer-dist --no-progress

 RUN apt-get install -y npm
 RUN npm install
 RUN npm run build

 RUN echo "daemon off;" >> /etc/nginx/nginx.conf

 EXPOSE 80

 CMD service php8.2-fpm start && nginx -g "daemon off;"
