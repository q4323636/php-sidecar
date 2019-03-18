<?php
namespace Sidecar;

use Sidecar\Client\Middleware;
use Sidecar\Client\Middleware\{HttpControl,FuseBefore,FuseAfter,FormatBefore,FormatAfter};
use Sidecar\Client\tool\Response;

class Client{

    public static function driver(array $opt=[]){
    	$rdate = new Response();
        $request = ["rdate"=>$rdate];

        $mware = new Middleware();
        $mware->make([[FormatBefore::class, 'handle'], null]);
        $mware->make([[FuseBefore::class, 'handle'], null]);
        $mware->make([[FormatAfter::class, 'handle'], null]);
        $mware->make([[FuseAfter::class,  'handle'], null]);
        $mware->make([[HttpControl::class,  'request'], null]);
        $mware->dispatch($request);

    }
    

}
