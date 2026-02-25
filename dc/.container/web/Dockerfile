# ベースイメージの指定
FROM nginx:latest

# 作成した設定ファイルをコンテナ内にコピー
COPY ./dc/.container/web/default.conf /etc/nginx/conf.d/default.conf

# Node.jsをインストール
RUN curl -sL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs

WORKDIR /var/www/html
