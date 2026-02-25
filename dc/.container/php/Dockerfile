# ベースイメージの指定
FROM php:8.3-fpm

ENV TZ Asia/Tokyo

# 作成した設定ファイルをコンテナ内にコピー
COPY ./dc/.container/php/php.ini /usr/local/etc/php/php.ini

# composerのインストール
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

# Node.jsをインストール
RUN curl -sL https://deb.nodesource.com/setup_lts.x | bash -

# パッケージのインストール
RUN apt-get update \
    && apt-get -y install git unzip libzip-dev libicu-dev libonig-dev nodejs libpng-dev libjpeg62-turbo-dev

RUN npm install -g yarn
RUN docker-php-ext-install intl pdo_mysql zip bcmath

RUN docker-php-ext-configure gd --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd

# コンテナ内で作業する際のカレンとディレクトリの指定
WORKDIR /var/www/html

RUN yarn install

# 開発サーバーを起動
CMD ["sh", "-c", "php-fpm & yarn dev"]
