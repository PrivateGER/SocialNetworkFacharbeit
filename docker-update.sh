BASEDIR=$(dirname "$0")

pushd "$BASEDIR/laradock"

sudo docker-compose exec workspace bash -c "composer install && npm install"

sudo docker-compose exec workspace bash -c "php artisan migrate:fresh && php artisan db:seed"

sudo docker-compose exec workspace bash -c "npm run dev"

popd
