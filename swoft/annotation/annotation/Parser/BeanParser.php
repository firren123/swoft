<?php
/**
 * Created by PhpStorm.
 * User: lichenjun
 * Date: 19/8/9
 * Time: 下午3:31
 */

namespace Annotation\Parser;


use Core\Bean;

class BeanParser
{
    public function parse($handle, $annotation): array
    {

//        $routeInfo = [
//            'action'  => $this->methodName,
//            'route'   => $annotation->getRoute(),
//            'method' => $annotation->getMethod(),
//            'params'  => $annotation->getParams(),
//        ];

        // Add route info for controller action
        Bean::addBean($handle, $annotation);

        return [];
    }
}