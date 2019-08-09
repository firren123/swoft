<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/9
 * Time: 上午11:29
 */

namespace Core;

/**
 * Class Route
 * @package Core
 */
class Route
{

    protected static $Routes=[];

    public static function addRoute($prefix, $path, $handler, $action){
        self::$Routes[] =['uri'=>$prefix.$path,'handler'=> $handler, 'action'=> $action];
    }

    public static function dispatch($url){
        foreach(self::$Routes as $route){
            if($route['uri'] === $url){
                $action = $route['action'];
                $route['handler']->$action();
            }
        }
    }

    public static function allRoutes(){
        return self::$Routes;
    }

}