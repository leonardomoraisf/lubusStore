<?php

use \App\Http\Response;
use \App\Controllers\Pages;

// HOME ROUTE
$router->get('/',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);


$router->get('/categories',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

$router->get('/categories/{id_categorie}/{acao}',[
    function($id_categorie,$acao){
        return new Response(200,'Categorie '.$id_categorie.' - '.$acao);
    }
]);

