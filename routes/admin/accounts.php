<?php

use \App\Http\Response;
use \App\Controller\Admin;

// GET
$router->get('/dashboard/forms/account',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Accounts::getFormAccount($request));
    }
]);

// POST
$router->post('/dashboard/forms/account',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Accounts::setFormAccount($request));
    }
]);