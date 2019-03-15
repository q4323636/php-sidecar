<?php
namespace Sidecar;

use Sidecar\Client\Middleware;
use Sidecar\Client\Middleware\{HttpControl,FuseBefore,FuseAfter};
use Sidecar\Client\tool\Response;

class Client
{
    public static function driver(array $opt=[]){
    	$rdate = new Response();
    	$request = ["rdate"=>$rdate];
    	$url = "http://kk.n.hanyuan365.com/";
    	//$url = "http://demo.hanyuan369.com/index.php/frontend/common/sigup";
    	$request["url"] = $url;


        $mware = new Middleware();
        $mware->make([[FuseBefore::class, 'handle'], null]);

        $mware->make([[FuseAfter::class,  'handle'], null]);
        $mware->make([[HttpControl::class,  'request'], null]);
        $mware->dispatch($request);
    }
    

}
