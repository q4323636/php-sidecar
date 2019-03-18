<?php
namespace Sidecar\Client\middleware;

class FormatBefore {
    public static function handle($request, \Closure $next) {
    	//业务逻辑，注意前置与后置中间件业务逻辑代码的位置
    	//echo 'Formatbefore',\PHP_EOL;
    	
        $url = "http://kk.n.hanyuan365.com/";
        //$url = "http://demo.hanyuan369.com/index.php/frontend/common/sigup";
        $request["url"] = $url;
        
        
        return $next($request);
    }

}

