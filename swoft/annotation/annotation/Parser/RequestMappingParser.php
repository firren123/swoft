<?php

namespace Annotation\Parser;

use Core\Route;
use Annotation\Mapping\AnnotationParser;
use Annotation\Parser\Parser;

/**
 * Class RequestMappingParser
 *
 * @since 2.0
 *
 * @AnnotationParser(RequestMapping::class)
 */
class RequestMappingParser
{
    /**
     * @param int            $type
     * @param RequestMapping $annotation
     *
     * @return array
     * @throws AnnotationException
     */
    public function parse($routePrefix, $routePath, $handle, $annotation): array
    {

//        $routeInfo = [
//            'action'  => $this->methodName,
//            'route'   => $annotation->getRoute(),
//            'method' => $annotation->getMethod(),
//            'params'  => $annotation->getParams(),
//        ];

        // Add route info for controller action
        Route::addRoute($routePrefix, $routePath, $handle, $annotation);

        return [];
    }
}
