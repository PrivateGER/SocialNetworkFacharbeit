BASEDIR=$(dirname "$0")

pushd "$BASEDIR/laradock"


sudo docker-compose exec workspace bash -c "composer install && npm install"

echo "Watching files..."
sudo docker-compose exec workspace bash -c "npm run watch"

popd
