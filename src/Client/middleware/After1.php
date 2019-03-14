<?php
namespace Sidecar\Client\middleware;

class After1 {
    public static function handle($request, Closure $next) {
        $response = $next($request);
        echo 'after1',PHP_EOL; //业务逻辑，注意前置与后置中间件业务逻辑代码的位置
        return $response;
    }
}

