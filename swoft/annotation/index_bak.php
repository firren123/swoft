<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/8
 * Time: 下午3:00
 * 命名空间找不到  问题要找到
 */
$load = require __DIR__ . "/vendor/autoload.php";
var_dump($load);
require __DIR__."/app/Http/HomesController.php";
$obj = new \App\Http\Controller\HomesController();
$re = new \ReflectionClass($obj);
$str = $re->getDocComment();

var_dump($str);

