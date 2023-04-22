<?php
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
include 'classes/db/DBConnection.php';

require __DIR__ . '/vendor/autoload.php';
require './config/database.php';

$db = new DBConnection(DB_SERVER, DB_DATABASE, DB_USER, DB_PASSWORD);



// Create App
$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);
//$app->addErrorMiddleware(false,false, false);

$app->get('/', function ($request, $response, $args) {

    phpinfo();
    exit;
})->setName('phpinfo');

$app->get('/tables', function (Request $request, Response $response, $args) {
    global $db;
    $response->getBody()->write(json_encode($db->get_tables()));
    return $response;

})->setName('tables');


$app->get('/hello/{name}', function ($request, $response, $args) {

    $renderer = new PhpRenderer('./pages/');
    return $renderer->render($response, "hello.php", $args);
})->setName('hello');

$app->run();

