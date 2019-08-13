<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/9
 * Time: 下午6:42
 * 组装数据，发送给客户端
 */
class RpcClient{
    public function __call($name, $arguments){
        if($name =="service"){
            $this->serviceName = $arguments[0]; //服务名称
            return $this;
        }
        $data = [
            'serviceName'=> $this->serviceName,
            'method'=> $name,
            'params'=> $arguments
        ];

        //json打包,pack函数打包
        $data = json_encode($data);
        //包头+包体
        $data = pack("N", strlen($data)).$data;

        //swoole的tcp客户端发送请求
        $client = new swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('127.0.0.1', 9508, -1))
        {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $client->send($data);

        echo $client->recv();
        $client->close();
    }

}