<?php

use \App\Http\Response;
use \App\Controller\Api;

// API LIST PRODUCTS ROUTE
$router->get('/api/v1/products',[
    'middlewares' => [
        'api',
        'admin-user-basic-auth',
        'cache',
    ],
    function($request){
        return new Response(200,Api\Product::getProducts($request),'application/json');
    }
]);

// API INDIVIDUAL CONSULT ROUTE
$router->get('/api/v1/products/{id}',[
    'middlewares' => [
        'api',
        'admin-user-basic-auth',
        'cache',
    ],
    function($request,$id){
        return new Response(200,Api\Product::getProduct($request,$id),'application/json');
    }
]);

// API REGISTER PRODUCT ROUTE
$router->post('/api/v1/products',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request){
        return new Response(201,Api\Product::setNewProduct($request),'application/json');
    }
]);

// API EDIT PRODUCT ROUTE
$router->put('/api/v1/products/{id}',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request,$id){
        return new Response(200,Api\Product::setEditProduct($request,$id),'application/json');
    }
]);

// API DELETE PRODUCT ROUTE
$router->delete('/api/v1/products/{id}',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request,$id){
        return new Response(200,Api\Product::setDeleteProduct($request,$id),'application/json');
    }
]);