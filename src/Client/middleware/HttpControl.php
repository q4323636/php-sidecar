<?php
namespace Sidecar\Client\middleware;

use Sidecar\Client\tool\Http;

//实际的控制器
class Httpcontrol {

	/**
	 * [request 实际执行的操作]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
    public static function request($request) {
    	
    	$chttp = new Http();
    	$creturn = $chttp->curlRetry($request['url']);
    	
    	($request["rdate"])->data($creturn);
    	sleep(3);
		echo 'control ',\PHP_EOL;
    	
    }

    
}

