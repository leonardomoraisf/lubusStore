<?php

use \App\Http\Response;
use \App\Controller\Admin;

// Home page ROUTES
// GET
$router->get('/dashboard',[
    function(){
        return new Response(200,Admin\Home::getHome());
    }
]);

// Home page ROUTES
// GET
$router->get('/dashboard/login',[
    function(){
        return new Response(200,Admin\Login::getLogin());
    }
]);

// Categories page ROUTES
// GET
$router->get('/dashboard/categories',[
    function(){
        return new Response(200,Admin\Categories::getCategories());
    }
]);

// Edit categorie ROUTES
// GET
$router->get('/dashboard/categories/{cat_id}/edit',[
    function($request,$cat_id){
        return new Response(200,Admin\Categories::getEditCategorie($request,$cat_id));
    }
]);
/*
// POST
$router->post('/categories/{cat_id}/edit',[
    function($request,$cat_id){
        return new Response(200,Admin\Categories::getEditCategorie($request,$cat_id));
    }
]);
*/

// Form categorie ROUTES
// GET
$router->get('/dashboard/forms/categorie',[
    function(){
        return new Response(200,Admin\Categories::getFormCategorie());
    }
]);
// POST
$router->post('/dashboard/forms/categorie',[
    function($request){
        return new Response(200,Admin\Categories::insertCategorie($request));
    }
]);




