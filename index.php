<?php
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
include 'classes/db/DBConnection.php';
include 'classes/db/DBInitializer.php';
include 'classes/db/DBQuery.php';

require __DIR__ . '/vendor/autoload.php';
require './config/database.php';
require './config/server.php';

$db = new DBConnection(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);



// Create App
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
//$app->addErrorMiddleware(false,false, false);


require './routes/api.php';
require './routes/pages.php';





$app->run();

