<?php
namespace Sidecar\Client\middleware;

use Sidecar\Client\tool\Mysql;

class FuseBefore {
    public static function handle($request, \Closure $next) {
    	//业务逻辑，注意前置与后置中间件业务逻辑代码的位置
    	echo 'before',\PHP_EOL;
    	$id = \md5($request['url']);
    	$mysql = Mysql::mysql('fuse');

    	$mdata = $mysql->find("id,status,open_time,close_times,fail_times,success_times",$id);
    	$mdatajson = json_decode(json_encode($mdata),true);
    	$data = array('id' => $id, 'open_time'=>time());
    	if (empty($mdatajson)) {
    		$madd = $mysql->add($data);
    	}else{
    		$mupd = $mysql->update($data);
    	}
        
        
        return $next($request);
    }

}

