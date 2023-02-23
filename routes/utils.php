<?php

use \App\Http\Response;
use \App\Controller\Utils;

// GET
$router->get('/404',[
    function($request){
        return new Response(404,Utils\Error::get404($request));
    }
]);
