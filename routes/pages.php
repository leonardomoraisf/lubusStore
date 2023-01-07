<?php

use \App\Http\Response;
use \App\Controllers\Pages;

// Home ROUTE
$router->get('/',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

// Categories
$router->get('/categories',[
    function($request){
        return new Response(200,Pages\Categories::getCategories($request));
    }
]);
$router->get('/categories/edit/{categorie_id}',[
    function($request,$categorie_id){
        return new Response(200,Pages\Categories::getEditCategorie($request,$categorie_id));
    }
]);

// Foms Categorie ROUTE
$router->get('/forms/categorie',[
    function(){
        return new Response(200,Pages\Categories::getFormCategorie());
    }
]);
$router->post('/forms/categorie',[
    function($request){
        return new Response(200,Pages\Categories::insertCategorie($request));
    }
]);


