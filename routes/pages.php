<?php

global $app;

use Slim\Views\PhpRenderer;

$renderer = new PhpRenderer('./pages/');

$app->get('/', function ($request, $response, $args) {
    global $renderer;

    return $renderer->render($response, ".php", $args);
})->setName('home');

$app->get('/cash-registers', function ($request, $response, $args){
    global $renderer;
    $args['cash_registers'] = DBQuery::get_cash_registers();
    return $renderer->render($response, "cash_registers.php", $args);
})->setName('cash-registers');

$app->get('/revenues', function ($request, $response, $args){
    global $renderer;
    $args['cash_registers'] = DBQuery::get_cash_registers();
    $args['tax_rates'] = DBQuery::get_tax_rates();
    $args['revenues'] = DBQuery::get_revenues_last10();
    return $renderer->render($response, "revenues.php", $args);
})->setName('revenues');

$app->get('/initial_cash_status', function ($request, $response, $args){
    global $renderer;
    $args['initial_cash_status'] = DBQuery::initial_cash_status();
    return $renderer->render($response, "initial_cash_status.php", $args);
})->setName('initial_cash_status');
