FROM laravelsail/php80-composer:latest

COPY . .

RUN composer install --ignore-platform-reqs

CMD ["php artisan up"]

