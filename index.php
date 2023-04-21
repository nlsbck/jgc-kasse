<?php
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;

require __DIR__ . '/vendor/autoload.php';



// Create App
$app = AppFactory::create();

$app->get('/hello/{name}', function ($request, $response, $args) {

    $renderer = new PhpRenderer('./pages/');
    return $renderer->render($response, "hello.php", $args);
})->setName('profile');

$app->run();

