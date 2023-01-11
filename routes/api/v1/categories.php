<?php

use \App\Http\Response;
use \App\Controller\Api;

// API LIST CATEGORIES ROUTE
$router->get('/api/v1/categories',[
    'middlewares' => [
        'api',
        'admin-user-basic-auth',
        'cache',
    ],
    function($request){
        return new Response(200,Api\Category::getCategories($request),'application/json');
    }
]);

// API INDIVIDUAL CONSULT ROUTE
$router->get('/api/v1/categories/{id}',[
    'middlewares' => [
        'api',
        'admin-user-basic-auth',
        'cache',
    ],
    function($request,$id){
        return new Response(200,Api\Category::getCategory($request,$id),'application/json');
    }
]);

// API REGISTER CATEGORY ROUTE
$router->post('/api/v1/categories',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request){
        return new Response(201,Api\Category::setNewCategory($request),'application/json');
    }
]);

// API EDIT CATEGORY ROUTE
$router->put('/api/v1/categories/{id}',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request,$id){
        return new Response(200,Api\Category::setEditCategory($request,$id),'application/json');
    }
]);

// API DELETE CATEGORY ROUTE
$router->delete('/api/v1/categories/{id}',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request,$id){
        return new Response(200,Api\Category::setDeleteCategory($request,$id),'application/json');
    }
]);