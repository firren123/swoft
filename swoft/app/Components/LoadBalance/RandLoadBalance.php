<?php

/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/9/3
 * Time: 上午12:31
 */
namespace App\Components\LoadBalance;


class RandLoadBalance implements LoadBalanceInterface
{
    public static function select(array $serviceList): array
    {
        $sum = 0; //总的权重值
        $weightsList = [];
        foreach ($serviceList as $k => $v) {
            $sum += $v['weight'];
            $weightsList[$k]=$sum;
        }
        $rand=mt_rand(0,$sum);
        //var_dump($weightsList,'随机数'.$rand);
        foreach ($weightsList as $k=>$v){
            if($rand<=$v){
                return $serviceList[$k];
            }
        }

    }
}