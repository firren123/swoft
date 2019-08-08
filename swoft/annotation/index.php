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

$obj = new \App\Http\Controller\HomeController();

$re = new ReflectionClass($obj);

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader,'loadClass']);

$reader = new \Doctrine\Common\Annotations\AnnotationReader();
$obj = new \App\Http\Controller\HomeController();
$re = new \ReflectionClass($obj);

$class_anno = $reader->getClassAnnotations($re);
//$a = $re->getMethod('index');
var_dump($class_anno);
