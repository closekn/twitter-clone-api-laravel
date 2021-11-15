# Twitter clone API

ゆめみインターン課題で色々試してみる

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
# マイグレーション&シーディング
$ ./vendor/bin/sail artisan migrate:fresh --seed
```

[localhost:80](http://localhost:80) で確認

## API仕様

- API仕様
    - https://closekn.github.io/twitter-clone-api-laravel/
- 実行サンプル
    - [.docs/http/sample.http](.docs/http/sample.http)

## 開発

- ブランチルール
    - GitHub Flow
- API設計
    - RESTをベースに
- コード設計
    - 参考 : https://zenn.dev/mpyw/articles/ce7d09eb6d8117
- 開発
    - TDD (できるだけ)
