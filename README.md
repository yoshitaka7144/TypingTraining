# TypingTraining

![demo](https://user-images.githubusercontent.com/18690548/134173381-d31798b0-22a3-4148-aa90-62e88ba80877.gif)

# 概要
* タイピング練習webアプリケーションです。
* 問題作成、履歴データ閲覧も可能です。
* PCでの実行、閲覧を想定して作成しています。 

# URL
https://typing.mikanbako.jp

# 使用言語
* PHP
* Javascript
* HTML
* CSS
* MySQL

# フレームワーク
* Laravel@6.20.32
* Vue@2.6.14

# ライブラリ、プラグイン等
* vue-router@3.5.2
* vuex@3.6.2
* chart.js@2.9.3
* vue-chartjs@3.5.1
* chartjs-plugin-datalabels@1.0.0
* vue-js-modal@2.0.1

# 開発環境
* Windows10
* XAMPP
* Visual Studio Code

# 機能一覧
* トップ画面
  * 会員メニュー
  * タイピングメニュー
  * 履歴データ
* ログイン/新規登録画面
  * ログイン
  * 新規ユーザー登録
* 問題編集画面
  * データ一覧閲覧
  * 作成
  * 編集
  * 削除
* タイピング画面
  * 待機画面
  * タイピング
  * 結果表示

# テーブル定義書
テーブル定義書です。  
<a href="https://docs.google.com/spreadsheets/d/1kVXoGfiHeqIjOmaL_yGdpNlI5RM-VdwZH-dEmz2TPb0/edit?usp=sharing" target="_blank" rel="noopener noreferrer">テーブル定義書（Googleスプレッドシート）</a>

# 使用方法
## トップ画面
![top_top](https://user-images.githubusercontent.com/18690548/134171044-8f684a3a-e0b3-4249-816e-c805b1bc49a9.PNG)
会員メニュー、タイピングメニュー、履歴データが表示されます。
### 会員メニュー
非ログイン時
* ログインボタン：ログイン

ログイン時
* 問題編集ボタン：問題編集ページへ遷移
* ログアウトボタン：ログアウト
* ユーザー名：登録ユーザー名を表示
* 総タイプ数：今までの合計タイプ数（ミスタイプは含まず）を表示
* 平均WPM：今までの平均WPMを表示
### タイピングメニュー
登録されているタイピングカテゴリーが表示されます。クリックするとタイピング用のモーダルウィンドウが開かれます。
### 履歴データ
![top_history](https://user-images.githubusercontent.com/18690548/134147349-3b9a281f-f61c-4e03-938d-c3d36414c26f.png)

ログインユーザーのみ表示されます。今までの履歴データを閲覧でき、対象カテゴリーを変更することで表示を変更できます。
## ログイン/新規登録画面
ログインまたは新規ユーザー登録を行いログインできます。

![login](https://user-images.githubusercontent.com/18690548/134130777-78d02649-54d6-4311-b4f4-07aae08f8bc1.gif)

### ログイン
ユーザー名とパスワードを入力してログインします。
### 新規ユーザー登録
ユーザー名とパスワードを入力して新規登録します。パスワードは半角英数字4文字以上の制限があります。既に存在しているユーザー名の場合は登録できません。

## 問題編集画面
### データ一覧表示
![question_view](https://user-images.githubusercontent.com/18690548/134158885-62bd9d60-0238-426b-9788-06e7dba214ef.png)

登録されている問題データが表示されます。編集可能データのみ表示の切替もできます。テーブルヘッダーをクリックすることで昇順、降順で並び替えができます。検索機能を使用するとデータの絞り込みができます。
### 作成、編集
![question_create](https://user-images.githubusercontent.com/18690548/134140479-eb281c51-8e0e-4fd1-a385-3ceb27f468a1.gif)

問題データを作成できます。問題フォームへ入力された文字列からふりがなとローマ字を生成（[Yahoo ルビ振りWebAPI](https://developer.yahoo.co.jp/webapi/jlp/furigana/v2/furigana.html)を使用）できます。編集は自分が作成したデータのみ可能です。（管理者ユーザーは全て可能です）

### 削除
![question_delete](https://user-images.githubusercontent.com/18690548/134140777-7faca11b-80c4-41f2-b2c6-0826367b4b2f.gif)

問題データを削除します。自分が作成したデータのみ可能です。（管理者ユーザーは全て可能です）

## タイピング画面
タイピングを行う画面です。タイピングはPCでの操作を想定して作成しています。
### 待機画面
![typing_start](https://user-images.githubusercontent.com/18690548/134142623-13d909cd-6b64-4e4a-811b-7e16fe839ca2.png)

タイピングスタート待機画面です。タイピングでの設定を行います。スペースキー押下でタイピングがスタートします。（3秒のカウントダウンが始まります。）
* 問題数：出題される問題数
* 音声の有無：タイプミス時の音声の有無
* 制限時間の有無：問題の合計タイプ数とWPM目標値に応じた制限時間の有無
* WPM目標値：制限時間設定のWPM値
### タイピング
![typing_typing](https://user-images.githubusercontent.com/18690548/134144810-14e73407-e50e-46f8-be42-2d877b7f9bc1.png)

表示されているタイピング文字通りにタイピングを行います。音声有りの場合はミス時に音声が鳴ります。設定した問題数を終える、または制限時間設定有りの場合は残り時間が無くなると結果画面が表示されます。キー入力判定アルゴリズムは[柔軟な入力方法に対応したタイピングゲームの作り方](https://crieit.net/posts/dc0eb0f0a74f6e15e362e1f384d28f0d#%E6%9F%94%E8%BB%9F%E3%81%AA%E5%85%A5%E5%8A%9B%E6%96%B9%E6%B3%95%E3%81%AB%E5%AF%BE%E5%BF%9C%E3%81%99%E3%82%8B%E3%82%A2%E3%83%AB%E3%82%B4%E3%83%AA%E3%82%BA%E3%83%A0)で紹介されているものを参考、改変させていただきました。
* ①：問題
* ②：かな
* ③：タイピング文字（入力済み文字はオレンジ色）
* ④：制限時間バー
* ⑤：現在入力対象キー
* ⑥：現在入力対象キーの指
### 結果表示
![typing_result](https://user-images.githubusercontent.com/18690548/134145804-eb618489-1450-4e21-950f-b61807af3ad4.png)

タイピング結果が表示されます。履歴データ表示ボタンをクリックすると選択されているカテゴリーの履歴データが表示されます。
* WPM：1分間あたりのタイプ回数
* ミスタイプ数：間違ったキーをタイプした回数
* 正答率：ミスタイプ数 / 合計タイプ数 × 100
* ミスキー：ミスしたキーとその回数
* キーボード：ミスしたキーが回数の割合に応じて色付けされる

# リンク
* [柔軟な入力方法に対応したタイピングゲームの作り方](https://crieit.net/posts/dc0eb0f0a74f6e15e362e1f384d28f0d)：キー入力判定アルゴリズムを参考、改変させていただきました。
* [Yahoo ルビ振りWebAPI](https://developer.yahoo.co.jp/webapi/jlp/furigana/v2/furigana.html)：問題登録時に問題からふりがなとローマ字を生成する為に使用しました。
* <a href="https://github.com/yoshitaka7144" target="_blank" rel="noopener noreferrer">Githubアカウント</a>
* <a href="https://portfolio.mikanbako.jp" target="_blank" rel="noopener noreferrer">ポートフォリオ</a>