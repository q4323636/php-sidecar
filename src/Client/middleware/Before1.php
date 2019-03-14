<?php
namespace phpms\Client\middleware;

class Before1 {
    public static function handle($request, Closure $next) {
        echo 'before1',PHP_EOL;  //业务逻辑，注意前置与后置中间件业务逻辑代码的位置
        return $next($request);
    }

}

