BASEDIR=$(dirname "$0")

cp "$BASEDIR/laradock-env" "$BASEDIR/laradock/.env"

docker-compose up -d nginx php-fpm mysql
