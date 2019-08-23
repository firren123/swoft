# Consul在docker里集群安装
## 1.创建镜像

Dockerfile 文件
```yml
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


```
我创建的镜像，使用的镜像文件
```yml
docker pull firren/sonsul
```
## 2.创建网络
```yml
docker network create --subnet=192.168.2.0/24 consulnetwork
```
## 3.创建容器
```yml
docker run -itd --name consul --network consulnetwork -P --ip 192.168.2.10 consul
docker run -itd --name consul1 --network consulnetwork -P --ip 192.168.2.11 consul
docker run -itd --name consul2 --network consulnetwork -P --ip 192.168.2.12 consul
docker run -itd --name consul3 --network consulnetwork -P --ip 192.168.2.13 consul

docker run -itd --name consul4 --network consulnetwork -p 8500:8500 -P --ip 192.168.2.14 consul


```
## 4.启动consul
```yml
#第一台
 consul agent -server -ui -node=server -bootstrap-expect=3 -bind=192.168.2.10 -data-dir /consul/data -join=192.168.2.10 -client 0.0.0.0
#第二台
consul agent -server -node=server2 -bootstrap-expect=3 -bind=192.168.2.12 -data-dir=/consul/data  -join=192.168.2.10 
#第三台
consul agent -server -node=server3 -bootstrap-expect=3 -bind=192.168.2.13 -data-dir=/consul/data  -join=192.168.2.10


 consul agent -server -ui -node=server -bootstrap-expect=1 -bind=172.17.0.2 -data-dir /consul/data -join=172.17.0.2 -client 0.0.0.0

 consul agent -server -ui -node=server -bootstrap-expect=1 -bind=192.168.2.14 -data-dir /consul/data -join=192.168.2.14 -client 0.0.0.0

```

## 5.注册server
```yml
aliyun2:8500/v1agent/service/register

```

## 附件
```yml
参数含义
agent 
-server 表示启动的是一个服务
-bootstrap-expect 1 表示等待多少个节点再启动，这里1个，就是自己
-

```
文档地址
https://www.consul.io/api/agent/service.html