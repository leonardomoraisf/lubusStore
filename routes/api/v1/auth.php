<?php

use \App\Http\Response;
use \App\Controller\Api;

// API AUTHORIZATION ROUTE
$router->post('/api/v1/auth',[
    'middlewares' => [
        'api',
        'admin-user-basic-auth',
    ],
    function($request){
        return new Response(201,Api\Auth::generateToken($request),'application/json');
    }
]);