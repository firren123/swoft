<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/9/3
 * Time: 上午12:31
 */
namespace App\Components\LoadBalance;


interface LoadBalanceInterface
{
    public  static  function select(array $serviceList):array;
}