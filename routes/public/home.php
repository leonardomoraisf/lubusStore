<?php 

use \App\Http\Response;
use \App\Controller\Public;

// GET
$router->get('/',[
    'middlewares' => [
        'verify-user-visit',
        'cache',
    ],
    function($request){
        return new Response(200,Public\Home::getHome($request));
    }
]);

// GET
$router->get('/catalogo',[
    'middlewares' => [
        'verify-user-visit',
        'cache',
    ],
    function($request){
        return new Response(200,Public\Catalogo::getCatalogo($request));
    }
]);
