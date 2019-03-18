<?php
namespace Sidecar\Client\middleware;

use Sidecar\Client\tool\Mysql;

class FuseAfter {
    public static function handle($request, \Closure $next) {
        $response = $next($request);
        //业务逻辑，注意前置与后置中间件业务逻辑代码的位置
        //echo 'Fuseafter',\PHP_EOL;
        $id = \md5($request['url']);
    	$mysql = Mysql::mysql('fuse');
    	$nowtime = time();
    	$mdata = $mysql->find("id,status,open_time,close_times,fail_times,success_times",$id);
    	$mdatajson = json_decode(json_encode($mdata),true);
    	$data = array('id' => $id, 'close_times'=>$nowtime);
    	$rdate = ($request["rdate"])->getData();

    	if (!empty($mdatajson)) {
    		if (!$rdate) {
    			$data['fail_times'] = $mdatajson['fail_times'] + 1;
			}

    		if ($mdatajson['fail_times'] >= 3) {
    			$data['fail_times'] = 0;
    			$data['success_times'] = 0;
    			$data['status'] = $nowtime;
    		}elseif ($mdatajson['fail_times'] >0 && ($nowtime - $mdatajson['close_times']) >60) {
                if ($rdate) {
                    $data['fail_times'] = 0;
                    $data['success_times'] = 0;
                }else{
                    $data['fail_times'] = 1;
                    $data['success_times'] = 0;
                }
            }elseif ($mdatajson['fail_times'] >0 && $mdatajson['fail_times'] < 3) {
				if ($rdate) {
					$data['success_times'] = $mdatajson['success_times'] + 1;
				}
    		}

    		$mupd = $mysql->update($data);
    	}

        
        return $response;
    }
}

