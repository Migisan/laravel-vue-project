# Laravel+Vue.js プロジェクトテンプレート

## 概要図

![](document/system.drawio.svg)

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
or
docker ps
```

### Laravel,npm パッケージ のインストール

```
docker-compose exec --user=laradock workspace bash
$ composer install
$ npm install
$ npm run dev
$ exit
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
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
$ exit
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
$ mysql -u laradock/.envのMYSQL_USER -p
$ laradock/.envのMYSQL_PASSWORD
```

フロントエンドのビルド

```
$ npm run dev
or
$ npm run watch
```

## アーキテクチャ

レイアードアーキテクチャを採用。

- フォームリクエスト
- API リソース
- コントローラー
- サービスクラス
- リポジトリ
- モデル

### フォームリクエスト

リクエストのバリデーションを行う。<br>
バリデーション成功時には、コントローラーに処理を移す。
バリデーション失敗時には、エラーメッセージと共にレスポンスを返す。(リダイレクト)<br>
※なお。エラー発生時の処理はフォームリクエストのメソッドオーバーライドやプロパティ設定でカスタマイズ可能。

### API リソース

レスポンスの JSON データを整形する。<br>
API のレスポンスとして、モデルやモデルコレクションを元に JSON データを整形を行う。

### コントローラー

リクエストを受けた後に、処理を振り分ける。<br>
サービスに処理を委譲し、レスポンスを返す。

### サービスクラス

ビジネスロジックを処理する。コントローラーから呼び出される。<br>
また、リポジトリを呼び出すことができる。<br>
コンストラクタインジェクションで依存性の注入を行う。<br>

### リポジトリ

データベースの I/O を行う。サービスクラスから呼び出される。<br>
また、直接モデルを呼び出すことができる。<br>
コンストラクタインジェクションで依存性の注入を行う。<br>
また、インターフェースを継承すること。<br>
※インターフェースで DI を行う場合には、サービスプロバイダへの登録が必要。

### モデル

データベースのデータにアクセスする。<br>
リレーションなどのテーブルに関する定義を行う。

### 命名規則

| 用途               | 命名          | 規則                           |
| ------------------ | ------------- | ------------------------------ |
| 変数名(PHP)        | $sample_value | スネークケース                 |
| 変数名(JavaScript) | sampleValue   | ローワーキャメルケース         |
| メソッド名         | getData       | ローワーキャメルケース         |
| クラス             | SampleClass   | アッパーキャメルケース         |
| モデル             | User          | アッパーキャメルケース(単数形) |
| テーブル           | users         | スネークケース(複数形)         |

## 開発

### マイグレーション(テーブル)

テーブル作成のマイグレーション

```
$ php artisan make:migration create_samples_table
```

マイグレーションの実行

```
$ php artisan migrate
```

マイグレーションの状態確認

```
$ php artisan migrate:status
```

ロールバックの実行

```
$ php artisan migrate:rollback
```

リフレッシュ(ロールバックとマイグレーション)と全シードの実行

```
$ php artisan migrate:refresh --seed
```

### シーダー(初期データ)

シーダーの作成

```
$ php artisan make:seeder SampleSeeder
```

シーダーの実行

```
// オートローダーの再生成
$ composer dump-autoload

// 全シーダー
$ php artisan db:seeder

// 個別シーダー
$ php artisan db:seeder --class=SampleSeeder
```

### モデル

モデルの作成

```
$ php artisan make:model Sample
```

### コントローラー

コントローラーの作成

```
$ php artisan make:controller SampleController
```

リソースコントローラーの作成

```
$ php artisan make:controller SampleController --resource
```

### フォームリクエスト(バリデーション)

フォームリクエストの作成

```
$ php artisan make:request SampleRequest
```

### API リソース(レスポンス)

API リソースの作成

```
$ php artisan make:resource SampleResource
```

### ルーティング

ルーティングの確認

```
$ php artisan route:list
```

### ビュー

シンボリックリンクを張る

```
$ php artisan storage:link
```

## テスト

### テストデータ

ファクトリーの作成

```
$ php artisan make:factory SampleFactory
```

### テストの作成

テストクラスの作成

```
$ php artisan make:test SampleApiTest
```

テスト後のデータベースのリセット

```
use RefreshDatabase;
```

テストの実行(バックエンド)

```
// 全テスト
$ php artisan test
or
$ ./vendor/bin/phpunit --testdox

// 個別テスト
$ php artisan test tests/Feature/SampleTest.php
or
$ ./vendor/bin/phpunit tests/Feature/SampleTest.php
```

テストの実行(フロントエンド)

```
// 全テスト
$ npm run test

// 個別テスト
$ npm run test resources/js/tests/components/ExampleComponent.test.js
```

### 自動テスト(CircleCI)

ローカルでの実行

```
circleci local execute
```

テストが成功した場合のみ master ブランチに merge できるように保護する

- Settings > Branches > Branch protection rules > Add rule をクリック
- Branch name pattern : master
- Require status checks to pass before merging : check
- Require branches to be up to date before merging : check

また、管理者にもルールを適用する場合には下記項目もチェックする<br>
※管理者も master に直接 push できなくなるので注意する

- Include administrators : check

## ER 図(データベース設計)

![](document/er.drawio.svg)
