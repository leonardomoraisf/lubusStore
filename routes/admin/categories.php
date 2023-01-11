<?php

use \App\Http\Response;
use \App\Controller\Admin;


// GET
$router->get('/dashboard/categories',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Categories::getCategories($request));
    }
]);


// Edit categorie ROUTES
// GET
$router->get('/dashboard/categories/{cat_id}/edit',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request,$cat_id){
        return new Response(200,Admin\Categories::getEditCategory($request,$cat_id));
    }
]);

// POST
$router->post('/dashboard/categories/{cat_id}/edit',[
        'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request,$cat_id){
        return new Response(200,Admin\Categories::setEditCategory($request,$cat_id));
    }
]);

// GET
$router->get('/dashboard/categories/{cat_id}/delete',[
    'middlewares' => [
    'required-admin-login',
    'verify-admin-session',
],
function($request,$cat_id){
    return new Response(200,Admin\Categories::getDeleteCategory($request,$cat_id));
}
]);

// POST
$router->post('/dashboard/categories/{cat_id}/delete',[
    'middlewares' => [
    'required-admin-login',
    'verify-admin-session',
],
function($request,$cat_id){
    return new Response(200,Admin\Categories::setDeleteCategory($request,$cat_id));
}
]);


// Form categorie ROUTES
// GET
$router->get('/dashboard/forms/category',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Categories::getFormCategory($request));
    }
]);

// POST
$router->post('/dashboard/forms/category',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Categories::setFormCategory($request));
    }
]);