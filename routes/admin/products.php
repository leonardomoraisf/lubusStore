<?php

use \App\Http\Response;
use \App\Controller\Admin;

// GET
$router->get('/dashboard/products',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Products::getProducts($request));
    }
]);


// Edit Product ROUTES
// GET
$router->get('/dashboard/products/{p_id}/edit',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request,$p_id){
        return new Response(200,Admin\Products::getEditProduct($request,$p_id));
    }
]);

// POST
$router->post('/dashboard/products/{p_id}/edit',[
        'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request,$p_id){
        return new Response(200,Admin\Products::setEditProduct($request,$p_id));
    }
]);

// GET
$router->get('/dashboard/products/{p_id}/delete',[
    'middlewares' => [
    'required-admin-login',
    'verify-admin-session',
],
function($request,$p_id){
    return new Response(200,Admin\Products::getDeleteProduct($request,$p_id));
}
]);

// POST
$router->post('/dashboard/products/{p_id}/delete',[
    'middlewares' => [
    'required-admin-login',
    'verify-admin-session',
],
function($request,$p_id){
    return new Response(200,Admin\Products::setDeleteProduct($request,$p_id));
}
]);


// Form categorie ROUTES
// GET
$router->get('/dashboard/forms/product',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Products::getFormProduct($request));
    }
]);

// POST
$router->post('/dashboard/forms/product',[
    'middlewares' => [
        'required-admin-login',
        'verify-admin-session',
    ],
    function($request){
        return new Response(200,Admin\Products::setFormProduct($request));
    }
]);