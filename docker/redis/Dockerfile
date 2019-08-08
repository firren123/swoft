#获取镜像操作系统
FROM centos
RUN groupadd -r redis && useradd -r -g redis redis
RUN  yum update -y && yum install epel-release -y && yum install centos-release-scl-rh -y &&  yum -y install redis
RUN mkdir -p /config && chown -R redis:redis /config
#copy
COPY . /config
#设置工作目录
WORKDIR /config
#容器创建的时候才会触发
#CMD ['redis-server']
