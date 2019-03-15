<?php
namespace Sidecar\Client\middleware;

use Sidecar\Client\tool\Mysql;

class FuseAfter {
    public static function handle($request, \Closure $next) {
        $response = $next($request);
        //业务逻辑，注意前置与后置中间件业务逻辑代码的位置
        echo 'after',\PHP_EOL;
        $id = \md5($request['url']);
    	$mysql = Mysql::mysql('fuse');

    	$mdata = $mysql->find("id,status,open_time,close_times,fail_times,success_times",$id);
    	$mdatajson = json_decode(json_encode($mdata),true);
    	$data = array('id' => $id, 'close_times'=>time());
    	if (!empty($mdatajson)) {
    		$mupd = $mysql->update($data);
    	}

    	var_dump(array_merge($mdatajson,$data));
        
        echo ($request["rdate"])->getData();
        
        return $response;
    }
}

