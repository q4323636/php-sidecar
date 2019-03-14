<?php
namespace Sidecar\Client\middleware;

//模拟的控制器
class Control {
    public static function index($request) {
        echo 'controller ',$request,PHP_EOL;
    }
}

