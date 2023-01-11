<?php

use \App\Http\Response;
use \App\Controller\Api;

// API LIST ADMIN USERS ROUTE
$router->get('/api/v1/admin/users',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request){
        return new Response(200,Api\Account::getUsers($request),'application/json');
    }
]);

// API INDIVIDUAL ACTUAL USER CONSULT ROUTE
$router->get('/api/v1/admin/users/me',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request){
        return new Response(200,Api\Account::getCurrentUser($request),'application/json');
    }
]);

// API INDIVIDUAL CONSULT ROUTE
$router->get('/api/v1/admin/users/{id}',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request,$id){
        return new Response(200,Api\Account::getUser($request,$id),'application/json');
    }
]);

// API REGISTER USER ROUTE
$router->post('/api/v1/admin/users',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request){
        return new Response(200,Api\Account::setNewAccount($request),'application/json');
    }
]);

// API EDIT USER ROUTE
$router->put('/api/v1/admin/users/{id}',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request,$id){
        return new Response(200,Api\Account::setEditAccount($request,$id),'application/json');
    }
]);

// API DELETE USER ROUTE
$router->delete('/api/v1/admin/users/{id}',[
    'middlewares' => [
        'api',
        'jwt-auth',
    ],
    function($request,$id){
        return new Response(200,Api\Account::setDeleteAccount($request,$id),'application/json');
    }
]);
