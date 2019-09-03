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
    const REGISTER_PATH='/v1/agent/service/register';  //注册服务
    const GET_REGISTERS_PATH='/v1/agent/services';   //获取服务列表
    const GET_REGISTER_PATH='/v1/agent/service/';   //获取单个服务
    const HEALTH_PATH='/v1/health/service/';   //获取健康服务

    /**
     * 注册服务
     * @param $config
     */
    public function registerServer($config){
        //配置文件
        $url = 'http://'.$config['address'].':'.$config['port'].self::REGISTER_PATH;
        SaberGM::put($url,json_encode($config['register']));
        output()->writeln("<success>Rpc service Register success by consul tcp={$config['address']}:{$config['port']}</success>");
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
        $url = 'http://'.$config['address'].':'.$config['port'].self::GET_REGISTER_PATH.$server;
        return $data = SaberGM::get($url);
    }

    /**
     * 获取健康服务信息
     */
    public function getHealthService($server){
        $config = bean('config')->get('provider.consul');
        $url = 'http://'.$config['address'].':'.$config['port'].self::HEALTH_PATH.$server;
        $data = file_get_contents($url);
        $arr = json_decode($data,1);
        $address = [];
        foreach($arr as $k=>$val){
            //判断当前的服务是否是活跃的，并且是当前想要去查询服务
            foreach($val['Checks'] as $c){
                if( $c['ServiceName']== $server && $c['Status'] == "passing"){
                    $address[$k]['address'] = $val['Service']['Address'].":".$val['Service']['Port'];
//                    $address[$k]['weight'] = $val['Weight']['Passing'];
                }
            }
        }
        return $address;
    }

    public function getServerList($server){
        $config = bean('config')->get('provider.consul');
        $url = 'http://'.$config['address'].':'.$config['port'].self::HEALTH_PATH.$server."?dc=dc1";
        $data = file_get_contents($url);
        $arr = json_decode($data,1);
        $address = [];
        foreach($arr as $k=>$val){
            //判断当前的服务是否是活跃的，并且是当前想要去查询服务
            foreach($val['Checks'] as $c){
                if( $c['ServiceName']== $server && $c['Status'] == "passing"){
                    $address[$k]['address'] = $val['Service']['Address'].":".$val['Service']['Port'];
                    $address[$k]['Weights'] = $val['Service']['Weights']['Passing'];
                }
            }
        }
        return $address;
    }

}