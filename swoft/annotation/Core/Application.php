<?php

/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/9
 * Time: 上午11:12
 */
namespace Core;

use Annotation\Mapping\RequestMapping;
use Annotation\Parser\RequestMappingParser;
use \Doctrine\Common\Annotations\AnnotationRegistry;

class Application
{
    protected static $beans;

    public static function init()
    {
        $loader = require dirname(__DIR__) . "/vendor/autoload.php";

        AnnotationRegistry::registerLoader([$loader, 'loadClass']);


        self::loadAnnotationBean();

        self::loadAnnotationRoute();
    }

    public static function loadAnnotationBean()
    {

        $reader = new \Doctrine\Common\Annotations\AnnotationReader();
        $obj = new Route();
        $re = new \ReflectionClass($obj);
        $class_annos = $reader->getClassAnnotations($re);
        foreach ($class_annos as $class_anno) {
            $routeName = $class_anno->getName();
            self::$beans[$routeName] = $re->newInstance();

        }
    }

    public static function getBeans(){
        return self::$beans;
    }

    public static function loadAnnotationRoute()
    {

        $reader = new \Doctrine\Common\Annotations\AnnotationReader();
        $obj = new \App\Http\Controller\HomeController();
        $re = new \ReflectionClass($obj);
        $class_annos = $reader->getClassAnnotations($re);
        foreach ($class_annos as $class_anno) {
            $routePrefix = $class_anno->getPrefix();
            //通过反射得到所有方法
            $refMethods = $re->getMethods();
            foreach ($refMethods as $method) {
                $methodAnnos = $reader->getMethodAnnotations($method);
                foreach ($methodAnnos as $methodAnno) {
                    $routePath =$methodAnno->getRoute();
                    //在某个解析类当中处理逻辑
                    (new RequestMappingParser())->parse($routePrefix, $routePath, $re->newInstance(), $method->name);


                }
            }

        }
    }
}