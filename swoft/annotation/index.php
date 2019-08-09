<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/8
 * Time: 下午3:00
 */
//$load = require __DIR__ . "/vendor/autoload.php";
//$obj = new \App\Http\Controller\HomeController();
//$re = new \ReflectionClass($obj);
//$str = $re->getDocComment();
//
//var_dump($str);

$loader = require __DIR__ . "/vendor/autoload.php";

\Core\Application::init();

//var_dump(\Core\Route::all());exit;

$server = new Swoole\Http\Server('0.0.0.0',9500);

$server->on("request",function($request, $response){
    var_dump(\Core\Bean::allBeans());
});

$server->start();