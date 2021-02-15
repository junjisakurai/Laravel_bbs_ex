【入門】Laravelチュートリアル ? 掲示板を作成してみよう
https://blog.hiroyuki90.com/articles/laravel-bbs/

# RestaurantApp2
レストラン料理注文WEBアプリ
<br>
<br>
■ 概要<br>
progateで作成する料理注文サイトにいくつか機能追加したモノです。<br>
<br>
追加した機能<br>
・データをDB化(ストアドプロシージャを使ったDB操作)<br>
・レビューの星評価<br>
・レビュー評価のチャート表示<br>
・レビューを投稿・編集・削除<br>
<br>
<br>
■ VIEW  (サーバー：Heroku　DB：ClearDB MySQL)<br>
https://restaurant-app-rdb2-junji.herokuapp.com/
<br>
<br>
<br>
■ 画面構成
<br>
![ポートフォリオ画面-01](https://user-images.githubusercontent.com/54252926/107885693-1f149f00-6f3f-11eb-9f7c-adf837d1f287.jpg)
<br>
■ ファイル構成
<pre>
●画面クラス ------------------------------------
トップ画面
index.php

レビュー閲覧画面
show.php

レビュー投稿・編集画面
review_edit.php

注文内容確認画面
confirm.php

★スタイルシート ----------------
stylesheet.css

■topへ戻る機能  ----------------
index.js
■画面遷移機能   ----------------
main.js

■レビュー      ----------------
レビュー表示機能
review_item.php

レビューDB登録機能
review_confirm.php

評価機能_チェック機能
review_edit.js

■チャート      -----------------
チャート描画スクリプト
Chart.js
チャートデータ作成
chartData.php

●DB関連    ----------------------------------------
■SP (ストアドプロシージャ)
sp_menu   (メニューデータ関連のSP)
sp_review (レビューデータ関連のSP)

■SP呼出 (ストアドプロシージャ呼出)
call_sp_menu.php   (メニューSP呼出)
call_sp_review.php (レビューSP呼出)

●データベース[Mysql]   ---------------------
menu_m  (メニューマスタ)
drink   (ドリンクテーブル)
food    (フードテーブル)
user_m  (ユーザーマスタ)
review  (レビューテーブル)
</pre>
