# Laravel+Vue.js プロジェクトテンプレート

## 環境構築

### プロジェクトのインストール

```
mkdir project
cd project
git clone https://github.com/Migisan/laravel-vue-project.git .
```

### Laradock の設定ファイル編集

```
cd laradock
cp .env.example .env
```

.env ファイル

```
// プロジェクト
APP_CODE_PATH_HOST=../src/
DATA_PATH_HOST=../.laradock/data
COMPOSER_PROJECT_NAME=プロジェクト名

// PHP
PHP_VERSION=7.4

// MySQL
MYSQL_VERSION=5.7
MYSQL_DATABASE=データベース名
MYSQL_USER=ユーザー名
MYSQL_PASSWORD=パスワード
```

### Docker コンテナの起動

```
docker-compose up -d nginx mysql phpmyadmin mailhog
```

コンテナの確認

```
docker ps --format "table {{.Names}}"
または
docker ps
```

### Laravel,npm パッケージ のインストール

```
docker-compose exec --user=laradock workspace bash
# composer install
# npm install
# npm run dev
# exit
```

### Laravel の設定ファイルの編集

```
cd ../src/
vim .env
```

.env ファイル

```
// データベース
DB_HOST=mysql
DB_DATABASE=laradock/.envのMYSQL_DATABASE
DB_USERNAME=laradock/.envのMYSQL_USER
DB_PASSWORD=laradock/.envのMYSQL_PASSWORD

// メール
MAIL_DRIVER=smtp
MAIL_DRIVER=mailhog
MAIL_PORT=1025
MAIL_USERNAME=user
MAIL_PASSWORD=password
MAIL_ENCRYTION=null
MAIL_FROM_NAME=送信者の名前
MAIL_FROM_ADDRESS=送信者のメールアドレス
```

### APP KEY の生成、DB 構築

```
docker-compose exec --user=laradock workspace bash
# php artisan key:generate
# php artisan migrate
# php artisan db:seed
# exit
```

### ブラウザで確認

- Laravel プロジェクト
  localhost
- phpMyAdmin
  localhost:8081
  サーバ：mysql
  ユーザー名：laradock/.env の MYSQL_USER
  パスワード：laradock/.env の MYSQL_PASSWORD
- MailHog
  localhost:8025

### 開発時コマンド

コンテナの操作

```
cd laradock
docker-compose up -d nginx mysql phpmyadmin mailhog // コンテナ起動
docker-compose exec --user=laradock workspace bash // コンテナへアクセス
docker-compose stop // コンテナ停止
```

MySQL の使用

```
docker-compose exec mysql bash
# mysql -u laradock/.envのMYSQL_USER -p
# laradock/.envのMYSQL_PASSWORD
```

フロントエンドのビルド

```
# npm run dev
or
# npm run watch
```

## 開発

### マイグレーション(テーブル)

テーブル作成のマイグレーション

```
# php artisan make:migration create_samples_table
```

マイグレーションの実行

```
# php artisan migrate
```

マイグレーションの状態確認

```
# php artisan migrate:status
```

マイグレーションのロールバック

```
# php artisan migrate:rollback
```

### シーダー(初期データ)

### モデル

モデルの作成

```
# php artisan make:model Sample
```

### コントローラー

コントローラーの作成

```
# php artisan make:controller SampleController
```

リソースコントローラーの作成

```
# php artisan make:controller SampleController --resource
```

### フォームリクエスト(バリデーション)

フォームリクエストの作成

```
# php artisan make:request SampleRequest
```

### ルーティング

ルーティングの確認

```
# php artisan route:list
```

## テスト

### テストデータ

ファクトリーの作成

```
# php artisan make:factory SampleFactory
```

### テストの作成

テストクラスの作成

```
# php artisan make:test SampleApiTest
```

テスト後のデータベースのリセット

```
use RefreshDatabase;
```

テストの実行

```
// 全テスト
./vendor/bin/phpunit --testdox

// 個別テスト
./vendor/bin/phpunit tests/Feature/SampleTest.php
```

## その他
