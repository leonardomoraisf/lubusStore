<?php

namespace App\Http\Middleware;

use Exception;

class Queue
{

    /**
     * Default Middlewares mapper
     * @var array
     */
    private static $default = [];

    /**
     * Middlewares mapper
     * @var array
     */
    private static $map = [];

    /**
     * Middlewares queue to execute
     * @var array
     */
    private $middlewares = [];

    /**
     * Execution function of controller
     * @var Closure
     */
    private $controller;

    /**
     * Function args of controller
     * @var array
     */
    private $controllerArgs = [];

    /**
     * Method to construct the queue class
     * @param array $middlewares
     * @param Closure $controller
     * @param array $controllerArgs
     */
    public function __construct($middlewares,$controller,$controllerArgs)
    {
        $this->middlewares = array_merge(self::$default,$middlewares);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    /**
     * Method to define the middlewares map
     * @param array $map
     */
    public static function setMap($map){
        self::$map = $map;
    }

    /**
     * Method to define the default middlewares map
     * @param array $default
     */
    public static function setDefault($default){
        self::$default = $default;
    }

    /**
     * Method to execute the next level of middlewares queue
     * @param Request $request
     * @return Response
     */
    public function next($request){
        
        // VERIFY EMPTY QUEUE
        if(empty($this->middlewares)) return call_user_func_array($this->controller,$this->controllerArgs);

        // MIDDLEWARE
        $middleware = array_shift($this->middlewares);
        
        // VERIFY MAPPING
        if(!isset(self::$map[$middleware])){
            throw new Exception("Problems processing request middleware!", 500);
        }

        // NEXT
        $queue = $this;
        $next = function($request) use($queue){
            return $queue->next($request);
        };

        // EXECUTE MIDDLEWARE
        return (new self::$map[$middleware])->handle($request,$next);

    }

}
