<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \App\Http\Middleware\Queue as MiddlewareQueue;

class Router
{
    /**
     * Complete url
     * @var string
     */
    private $url = '';

    /**
     * Prefix of all routes
     * @var string
     */
    private $prefix = '';

    /**
     * Routes indice
     * @var array
     */
    private $routes = [];

    /**
     * Request instance
     * @var Request
     */
    private $request;

    /**
     * Init class
     */
    public  function __construct($url)
    {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Method to define routes prefix
     */
    private function setPrefix()
    {
        // ACTUAL URL
        $parseUrl = parse_url($this->url);
        
        // DEFINE PREFIX
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Method to add route to class
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method,$route,$params= []){
        // VALIDATE PARAMS
        foreach ($params as $key => $value) {
            if($value instanceof Closure){
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        // ROUTE MIDDLEWARES
        $params['middlewares'] = $params['middlewares'] ?? [];

        // ROUTE VARS
        $params['variables'] = [];

        // VALIDATE STANDARDS OF ROUTE VARS
        $patternVariable = '/{(.*?)}/';
        if(preg_match_all($patternVariable,$route,$matches)){
            $route = preg_replace($patternVariable,'(.*?)',$route);
            $params['variables'] = $matches[1];
        }

        // VALIDATE URL PATTERN
        $patternRoute = '/^'.str_replace('/','\/',$route).'$/';
        
        // ADD ROUTE TO CLASS
        $this->routes[$patternRoute][$method] = $params;
        
    }

    /**
     * Method to define GET route
     * @param string $route
     * @param array $params
     */
    public function get($route,$params = []){
        return $this->addRoute('GET',$route,$params);
    }

    /**
     * Method to define POST route
     * @param string $route
     * @param array $params
     */
    public function post($route,$params = []){
        return $this->addRoute('POST',$route,$params);
    }

    /**
     * Method to define PUT route
     * @param string $route
     * @param array $params
     */
    public function put($route,$params = []){
        return $this->addRoute('PUT',$route,$params);
    }

    /**
     * Method to define DELETE route
     * @param string $route
     * @param array $params
     */
    public function delete($route,$params = []){
        return $this->addRoute('DELETE',$route,$params);
    }

    /**
     * Method to return the uri without prefix
     * @return string
     */
    private function getUri(){
        // Request URI
        $uri = $this->request->getUri();
        
        // Separate the uri with prefix
        $xUri = strlen($this->prefix) ? explode($this->prefix,$uri) : [$uri];
        
        // return the uri without prefix
        return end($xUri);
    }

    /**
     * Method to return the date of actual route
     * @return array
     */
    private function getRoute(){
        //URI
        $uri = $this->getUri();
        
        //METHOD
        $httpMethod = $this->request->getHttpMethod();
        
        //VALID ROUTES
        foreach ($this->routes as $patternRoute=>$methods) {
            // VERIFY URI == PATTERN
            if(preg_match($patternRoute,$uri,$matches)){
                // VERIFY METHOD
                if(isset($methods[$httpMethod])){
                    // REMOVE FIRST POSITION
                    unset($matches[0]);

                    // PROCESSED VARS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys,$matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    // RETURN ROUTE PARAMS
                    return $methods[$httpMethod];
                }
                // METHOD NOT ALLOWED
                throw new Exception("The method is not allowed", 405);
            }
        }
        // URL NOT FOUND
        throw new Exception("URL not found", 404);
    }

    /**
     * Method to execute the actual route
     * @return Response
     */
    public function run(){
        try {
            // ACTUAL ROUTE
            $route = $this->getRoute();

            // VERIFY CONTROLLER
            if(!isset($route['controller'])){
                throw new Exception("The URL can't be processed", 500);
            }

            // FUNC ARGS
            $args = [];

            // REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            // RETURN QUEUE EXECUTION OF MIDDLEWARES
            return (new MiddlewareQueue($route['middlewares'],$route['controller'],$args))->next($this->request);

        } catch (Exception $e) {
            return new Response($e->getCode(),$e->getMessage());
        }
    }

    /**
     * Method to return the actual URL
     * @return string
     */
    public function getCurrentUrl(){
        return $this->url.$this->getUri();
    }

    /**
     * Method to redirect the URL
     * @param string $route
     */
    public function redirect($route){
        //URL
        $url = $this->url.$route;

        //EXECUTE REDIRECT
        header('location: '.$url);
        exit;
    }
}
