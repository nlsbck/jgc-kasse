<?php


use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
include 'classes/db/DBConnection.php';
include 'classes/db/DBInitializer.php';
include 'classes/db/DBQuery.php';
include 'classes/routing/URI.php';

require __DIR__ . '/vendor/autoload.php';
require './config/database.php';
require './config/server.php';

try {
    $db = new DBConnection(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);
} catch (Exception) {
    echo "<h1>Keine Verbindung zur Datenbank möglich</h1>";
    exit;
}




// Create App
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
//$app->addErrorMiddleware(false,false, false);


require './routes/api.php';
require './routes/pages.php';

define('ROUTES', $app->getRouteCollector());
define("URI", new URI($app->getRouteCollector()));


$app->run();

