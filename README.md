## Sail用コマンド

#### 起動コマンド: ```sail up```
#### バックグランドでの起動: ```sail up -d```

#### 停止: ```sail down```

#### scssのコンパイル ```sail npm run build```
#### 開発時のコマンド ```sail npm run dev```

---
## Arisan用コマンド

#### モデル作るコマンド: ```sail artisan make:model "モデル名"```
#### マイグレーションファイルの作成: ```sail artisan make:migration "テーブル名"```
#### コントローラー作成: ```sail artisan make:controller "コントローラー名" --resource```
#### routeをリストで表示: ```sail artisan route:list```
### Bossアカウント(1)、役職(13)、部署(9)、一般アカウント(20) (Pwd: test@123) ```sail artisan db:seed --class=DatabaseSeeder```
```sail artisan migrate```
```sail artisan config:clear```
```source ~/.zshrc```
```cmd + shift + k```

---
## LiveWire用コマンド

#### LiveWireのインストール: ```sail composer require livewire/livewire```
#### LiveWireのコンポーネント作成(コントローラーも含む) ```sail artisan make:livewire "コントローラー名"```
