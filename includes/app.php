<?php

require('vendor/autoload.php');

use \App\Utils\View;
use \WilliamCosta\DatabaseManager\Database;

// LOAD AMBIENT VARS
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$url = $_ENV['URL'];
$uploads = $_ENV['UPLOADS'];
$DB_DRIVE = $_ENV['DB_DRIVE'];
$DB_HOST = $_ENV['DB_HOST'];
$DB_USER = $_ENV['DB_USER'];
$DB_PASS = $_ENV['DB_PASS'];
$DB_NAME = $_ENV['DB_NAME'];

define('URL',$url);
define('UPLOADS',$uploads);
define('DB_DRIVE',$DB_DRIVE);
define('DB_HOST',$DB_HOST);
define('DB_USER',$DB_USER);
define('DB_PASS',$DB_PASS);
define('DB_NAME',$DB_NAME);

// DEFINE O BANCO
Database::config(DB_HOST,DB_NAME,DB_USER,DB_PASS);


// DEFINE PADRON VALUE OF VARS 
View::init([
        'URL' => URL,
]);