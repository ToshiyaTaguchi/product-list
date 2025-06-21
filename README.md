# mogitate(Product List Application)
Laravel + Docker 環境で構築された商品管理アプリケーションです。

---

## 環境構築
**Gitリポジトリの作成と初期セットアップ**
1. Laravel プロジェクトを作成する
2. 以下をプロジェクトルートで実行して Git 管理を開始する：
   ```bash
   git init
   echo "/vendor/" >> .gitignore
   echo "/node_modules/" >> .gitignore
   echo "/.env" >> .gitignore
   echo "/docker/mysql/data/" >> .gitignore
   git add .
   git commit -m "最初のコミット"
   git branch -m main
   git remote add origin git@github.com:ToshiyaTaguchi/product-list.git
   git push -u origin main

**Dockerビルド**
1. DockerDesktopアプリを立ち上げる
2. `docker-compose up -d --build`

> *MacのM1・M2チップのPCの場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください*
``` bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.envファイルを作成
4. .envに以下の環境変数を追加
``` text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
``` bash
php artisan key:generate
```

6. マイグレーションの実行
``` bash
php artisan migrate
```

7. シーディングの実行
``` bash
php artisan db:seed
```

## 使用技術(実行環境)
// 提出前要確認
- PHP8.3.0
- Laravel8.83.27
- MySQL8.0.26

## ER図
![alt](erd.png)

## URL
- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
