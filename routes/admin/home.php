<?php 

use \App\Http\Response;
use \App\Controller\Admin;


// GET
$router->get('/dashboard',[
    'middlewares' => [
        'required-admin-login',
    ],
    function(){
        return new Response(200,Admin\Home::getHome());
    }
]);
