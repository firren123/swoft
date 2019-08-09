<?php declare(strict_types=1);

namespace App\Http\Controller;
use Annotation\Mapping\Controller;
use Annotation\Mapping\RequestMapping;

/**
 * Class HomeController
 * @Controller(prefix="/index")
 */
class HomeController
{
    /**
     * @RequestMapping("/test")
     * @throws \Throwable
     */
    public function index()
    {
        echo "index11111111111111111";
    }
    /**
     * @RequestMapping("/er")
     * @throws \Throwable
     */
    public function er()
    {
        echo "er111111111111111111";
    }

    /**
     * @RequestMapping("/output")
     * @throws \Throwable
     */
    public function out()
    {
        echo "out111111111111111";
    }
}
