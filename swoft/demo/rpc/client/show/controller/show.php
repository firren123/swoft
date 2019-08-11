<?php
namespace  show\controller;

class  show{

    public function  index(){
        ob_start();
        include dirname(__DIR__) . '/view/show.php';
        $res=ob_get_contents();
        ob_end_clean();
        return $res;
    }
}
