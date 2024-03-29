FROM php:7.3-alpine
# Version
ENV PHPREDIS_VERSION 4.0.0
ENV SWOOLE_VERSION 4.3.4
#配置环境变量consul版本
ENV CONSUL_VERSION=1.4.3
ENV HASHICORP_RELEASES=https://releases.hashicorp.com


# Libs
RUN apk update \
    && apk  add  \
        curl \
        vim  \
        wget \
        git \
        openssl-dev\
        zip \
        unzip \
        g++  make autoconf

# Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer self-update --clean-backups

# docker方式安装PDO extension
RUN docker-php-ext-install pdo_mysql

# Redis extension
RUN wget http://pecl.php.net/get/redis-${PHPREDIS_VERSION}.tgz -O /tmp/redis.tar.tgz \
    && pecl install /tmp/redis.tar.tgz \
    && rm -rf /tmp/redis.tar.tgz \
    && docker-php-ext-enable redis
 # 修改php.ini的文件 extension=redis.so

#安装consul
RUN     wget ${HASHICORP_RELEASES}/consul/${CONSUL_VERSION}/consul_${CONSUL_VERSION}_linux_amd64.zip && \
        unzip consul_${CONSUL_VERSION}_linux_amd64.zip && \
        rm -rf consul_${CONSUL_VERSION}_linux_amd64.zip && \
        mv consul /usr/local/bin


# Swoole extension
RUN wget https://github.com/swoole/swoole-src/archive/v${SWOOLE_VERSION}.tar.gz -O swoole.tar.gz \
    && mkdir -p swoole \
    && tar -xf swoole.tar.gz -C swoole --strip-components=1 \
    && rm swoole.tar.gz \
    && ( \
        cd swoole \
        && phpize \
        && ./configure  --enable-mysqlnd  --enable-openssl  --enable-http2 \
        && make -j$(nproc) \
        && make install \
    ) \
    && rm -r swoole \
    && docker-php-ext-enable swoole

#切换镜像
RUN  composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/

VOLUME /consul/data

#设置工作目录
WORKDIR  /var/www/swoft





