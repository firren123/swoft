FROM  centos:7.4.1708
MAINTAINER  peter  "990979940@qq.com"

#配置环境变量consul版本
ENV CONSUL_VERSION=1.0.6
ENV HASHICORP_RELEASES=https://releases.hashicorp.com


#添加consul用户跟用户组
RUN groupadd consul && \
    useradd -g consul consul

#安装consul
RUN yum upgrade -y && \
    yum install -y net-tools && \
    yum install -y firewalld firewalld-config && \
    yum install -y wget && \
    yum install -y unzip && \
    wget ${HASHICORP_RELEASES}/consul/${CONSUL_VERSION}/consul_${CONSUL_VERSION}_linux_amd64.zip && \
    unzip consul_${CONSUL_VERSION}_linux_amd64.zip && \
    rm -rf consul_${CONSUL_VERSION}_linux_amd64.zip && \
    mv consul /usr/local/bin

RUN mkdir -p /consul/data && \
    chown -R consul:consul /consul

VOLUME /consul/data

#开放端口
EXPOSE 8300
EXPOSE 8301 8301/udp 8302 8302/udp
EXPOSE 8500 8600 8600/udp

