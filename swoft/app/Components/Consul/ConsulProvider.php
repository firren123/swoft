<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/22
 * Time: 下午6:39
 */

namespace App\Components\Consul;


use Swlib\SaberGM;

class ConsulProvider
{
    const REGISTER_PATH='/v1/agent/service/register';
    const GET_REGISTERS_PATH='/v1/agent/services';
    const GET_REGISTER_PATH='/v1/agent/service/';


    /**
     * 注册服务
     * @param $config
     */
    public function registerServer($config){
        //配置文件
        $url = 'http://'.$config['address'].':'.$config['port'].self::REGISTER_PATH;
        echo json_encode($config['register']);
        SaberGM::put($url,json_encode($config['register']));
        //注册地址
    }

    /**
     * 获取所有服务
     */
    public function getRegisterServers(){
        $config = bean('config')->get('provider.consul');
        $url = 'http://'.$config['address'].':'.$config['port'].self::GET_REGISTERS_PATH;
        return $data = SaberGM::get($url);
    }

    /**
     * 获取单个服务信息
     * @param $server
     * @return \Swlib\Saber\Request|\Swlib\Saber\Response
     */
    public function getServer($server){
        $config = bean('config')->get('provider.consul');
       echo  $url = 'http://'.$config['address'].':'.$config['port'].self::GET_REGISTER_PATH.$server;
        return $data = SaberGM::get($url);
    }

}