<?php

require('vendor/autoload.php');

use \App\Http\Router;
use \App\Utils\View;

// DEFINE PADRON VALUE OF VARS 
View::init([
        'URL' => URL,
]);

// INIT ROUTER
$router = new Router(URL);

// INCLUDE ROUTES
include('routes/pages.php');

// PRINT RESPONSE OF ROUTE
$router->run()
        ->sendResponse();