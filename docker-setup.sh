BASEDIR=$(dirname "$0")

cp "$BASEDIR/laradock-env" "$BASEDIR/laradock/.env"

pushd "$BASEDIR/laradock"

sudo docker-compose up -d nginx mysql php-fpm phpmyadmin

sudo docker-compose exec workspace bash -c "composer install && npm install -g npm && npm install && php artisan migrate:fresh && php artisan db:seed"

popd
