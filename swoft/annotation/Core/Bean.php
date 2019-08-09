<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/9
 * Time: 上午11:29
 */

namespace Core;

use Annotation\Mapping\BeanMapping;

/**
 * @BeanMapping("bean")
 * Class Bean
 * @package Core
 */
class Bean
{

    protected static $beans =[];

    public static function allBeans(){
        return self::$beans;
    }

    public static function addBean($handler, $action){
        self::$beans[] =['handler'=> $handler, 'name'=> $action];
    }

}