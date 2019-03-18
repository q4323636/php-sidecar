<?php
namespace Sidecar\Client\middleware;

use Sidecar\Client\tool\Mysql;

class FormatAfter {
    public static function handle($request, \Closure $next) {
        $response = $next($request);
        //业务逻辑，注意前置与后置中间件业务逻辑代码的位置
        //echo 'Formatafter',\PHP_EOL;
        ($request["rdate"])->output();

        
        return $response;
    }
}

