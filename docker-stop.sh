BASEDIR=$(dirname "$0")

git submodule init
git submodule update

cp "$BASEDIR/laradock-env" "$BASEDIR/laradock/.env"

pushd "$BASEDIR/laradock"

sudo docker-compose down

popd
