<?php
namespace phpms\Client;

class Middleware {

    //中间件队列
    private $queue;

    //设置中间件
    public function make(array $mfun) {
        //模拟的中间件，数量任意添加
        $this->queue[] = $mfun;
    }

    //调用中间件
    public function dispatch($request) {
        call_user_func($this->resolve(), $request);
    }

    //返回闭包函数
    public function resolve(){
        return function($request){
            $middleware = array_shift($this->queue);
            if ($middleware != null) {
                list($call, $param) = $middleware;
                //执行中间件
                call_user_func_array($call, [$request, $this->resolve(), $param]);
            }
        };
    }
}

