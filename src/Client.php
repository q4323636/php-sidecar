<?php
namespace Sidecar;

use Sidecar\Client\Middleware
use Sidecar\Client\Middleware\{Control,After1,Before1};

class Client
{
    public function driver(array $opt=[]){
    
        $mware = new Middleware();
        $mware->make([[After1::class,  'handle'], null]);
        $mware->make([[Before1::class, 'handle'], null]);
        $mware->make([[Control::class,  'index'], null]);
        $request = "myrequest";
        $mware->dispatch($request);
    }
    

}
