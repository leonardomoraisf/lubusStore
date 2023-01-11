<?php 

use \App\Http\Response;
use \App\Controller\Admin;

// GET LOGIN VIEW
$router->get('/dashboard/login',[
    'middlewares' => [
        'required-admin-logout'
    ],
    function($request){
        return new Response(200,Admin\Login::getLogin($request));
    }
]);

// POST FOR LOGIN
$router->post('/dashboard/login',[
    'middlewares' => [
        'required-admin-logout'
    ],
    function($request){
        return new Response(200,Admin\Login::setLogin($request));
    }
]);

// GET LOGOUT
$router->get('/dashboard/logout',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Login::setLogout($request));
    }
]);