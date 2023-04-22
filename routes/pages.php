<?php

global $app;

use Slim\Views\PhpRenderer;

$app->get('/hello/{name}', function ($request, $response, $args) {

    $renderer = new PhpRenderer('./pages/');
    return $renderer->render($response, "hello.php", $args);
})->setName('hello');

$app->get('/', function ($request, $response, $args) {
    $renderer = new PhpRenderer('./pages/');
    return $renderer->render($response, ".php", $args);
})->setName('home');