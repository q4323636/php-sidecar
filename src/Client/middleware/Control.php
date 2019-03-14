<?php
namespace Sidecar\Client\middleware;

//模拟的控制器
class Control {
    public static function index($request) {
        echo 'control-',$request,\PHP_EOL;
    }
}

