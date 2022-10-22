FROM webdevops/php-nginx:8.0 AS base

# COPY docker/conf/etc/supervisor.d/laravel-supervisor-pro.conf /opt/docker/etc/supervisor.d/laravel-supervisor.conf

# COPY --chown=application:application ./app /app/app
# COPY --chown=application:application ./bootstrap /app/bootstrap
# COPY --chown=application:application ./config /app/config
# COPY --chown=application:application ./database /app/database
# COPY --chown=application:application ./public /app/public
# COPY --chown=application:application ./resources /app/resources
# COPY --chown=application:application ./routes /app/routes
# COPY --chown=application:application ./storage /app/storage
# COPY --chown=application:application ./tests /app/tests
# COPY --chown=application:application ./artisan /app/artisan
# COPY --chown=application:application ./composer.json /app/composer.json
# COPY --chown=application:application ./modules_statuses.json /app/modules_statuses.json
# COPY --chown=application:application ./package.json /app/package.json
# COPY --chown=application:application ./phpunit.xml /app/phpunit.xml
# COPY --chown=application:application ./server.php /app/server.php
# COPY --chown=application:application ./webpack.mix.js /app/webpack.mix.js
# COPY --chown=application:application ./Modules /app/Modules
# COPY --chown=application:application ./packages /app/packages
# COPY --chown=application:application ./README.md /app/README.md

WORKDIR /app
USER application
COPY .env /app/.env
# RUN composer install --optimize-autoloader --no-dev
# RUN php artisan route:clear
# RUN php artisan cache:clear
# RUN php artisan migrate

EXPOSE 80 443 


