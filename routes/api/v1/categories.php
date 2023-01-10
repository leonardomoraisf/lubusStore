<?php

use \App\Http\Response;
use \App\Controller\Api;

// API LIST CATEGORIES ROUTE
$router->get('/api/v1/categories',[
    'middlewares' => [
        'api'
    ],
    function($request){
        return new Response(200,Api\Category::getCategories($request),'application/json');
    }
]);

// API INDIVIDUAL CONSULT ROUTE
$router->get('/api/v1/categories/{id}',[
    'middlewares' => [
        'api'
    ],
    function($request,$id){
        return new Response(200,Api\Category::getCategory($request,$id),'application/json');
    }
]);