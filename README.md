# Twitter clone API

## Set Up

```sh
# .env を作成
$ cp .env.example .env
# composer を導入してインストール
$ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php80-composer:latest \
    composer install --ignore-platform-reqs
# バックグラウンドで起動
$ ./vendor/bin/sail up -d
# APP_KEY 作成
$ ./vendor/bin/sail artisan key:generate
```

[localhost:80](http://localhost:80) で確認
