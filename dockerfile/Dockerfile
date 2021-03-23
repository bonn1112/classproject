FROM php:7.2-cli

# イメージ上で実行するコマンドを指定
# helloディレクトリを作成
RUN mkdir /hello
# helloディレクトリにmain.phpをコピー
COPY main.php /hello

# 実行コマンド
# php /hello/main.phpを実行
CMD [ "php", "/hello/main.php" ]