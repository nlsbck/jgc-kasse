<?php

global $app;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

$app->get('/init', function ($request, $response, $args) {
    global  $db;
    $dbi = new DBInitializer();
    $dbi->initialize($db);
    exit;
})->setName('phpinfo');

$app->get('/tables', function (Request $request, Response $response, $args) {
    global $db;
    $response->getBody()->write(json_encode($db->get_tables()));
    return $response;

})->setName('tables');