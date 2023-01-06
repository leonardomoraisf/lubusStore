<?php

namespace App\Http;

class Request
{
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
     * Header
     * @var array
     */
    private $headers = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
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
        return $this->queryParams;
    }

    /**
     * Method to return the post vars
     * @return array
     */
    public function getPostVars(){
        return $this->postVars;
    }
}
