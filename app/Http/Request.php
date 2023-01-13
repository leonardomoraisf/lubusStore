<?php

namespace App\Http;

class Request
{
    /**
     * Router instance
     * @var Router
     */
    private $router;

    /**
     * Http method
     * @var string
     */
    private $httpMethod;

    /**
     * URI
     * @var string
     */
    private $uri;

    /**
     * URL Params
     * @var array
     */
    private $queryParams = [];

    /**
     * Vars of $_POST
     */
    private $postVars = [];

    /**
     * Files of $_FILES
     */
    private $postFiles = [];

    /**
     * Header
     * @var array
     */
    private $headers = [];

    /**
     * Constructor
     */
    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postFiles = $_FILES ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->setUri();
        $this->setPostVars();
    }

    /**
     * Method to define post vars
     */
    private function setPostVars(){
        // VERIFY REQUEST METHOD
        if($this->httpMethod == 'GET') return false;

        // BASE DEFINITION POST
        $this->postVars = $_POST ?? [];

        // POST JSON
        $inputRaw = file_get_contents("php://input");
        $this->postVars = (strlen($inputRaw) && empty($_POST)) ? json_decode($inputRaw,true) : $this->postVars;

    }
    

    /**
     * Method to define uri
     */
    private function setUri(){
        // COMPLETE URI WITH GETS
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        // REMOVE GETS
        $xUri = explode('?',$this->uri);
        $this->uri = $xUri[0];
    }

    /**
     * Method to return an router instance
     * @return Router
     */
    public function getRouter(){
        return $this->router;
    }
    
    /**
     * Method to return the http method
     * @return string
     */
    public function getHttpMethod(){
        return $this->httpMethod;
    }

    /**
     * Method to return the uri
     * @return string
     */
    public function getUri(){
        return $this->uri;
    }

    /**
     * Method to return the headers
     * @return array
     */
    public function getHeaders(){
        return $this->headers;
    }

    /**
     * Method to return the params of URL
     * @return array
     */
    public function getQueryParams(){
        unset($this->queryParams['url']);
        return $this->queryParams;
    }

    /**
     * Method to return the post vars
     * @return array
     */
    public function getPostVars(){
        return $this->postVars;
    }

        /**
     * Method to return the post files
     * @return array
     */
    public function getPostFiles(){
        return $this->postFiles;
    }
}
