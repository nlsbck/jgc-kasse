<?php

global $app;

use Slim\Views\PhpRenderer;

$renderer = new PhpRenderer('./pages/');

$app->redirect('/', 'overview/' . date('Y'), 301)->setName('home');

$app->get('/overview/{year}', function ($request, $response, $args) {
    global $renderer;
    $year = $args['year'];
    $args['daily'] = DBQuery::get_yearly_overview($year);
    $args['monthly_expenses'] = DBQuery::get_expenses_grouped_by_month($year);
    $args['monthly_revenues'] = DBQuery::get_revenues_grouped_by_month($year);
    $args['initial_cash_status'] = DBQuery::get_cash_status_last_year($year);
    return $renderer->render($response, ".php", $args);
});

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

$app->get('/initial-cash-status', function ($request, $response, $args){
    global $renderer;
    $args['initial_cash_status'] = DBQuery::initial_cash_status();
    return $renderer->render($response, "initial_cash_status.php", $args);
})->setName('initial-cash-status');

$app->get('/tax-rates', function ($request, $response, $args){
    global $renderer;
    $args['tax_rates'] = DBQuery::get_tax_rates();
    //$args['initial_cash_status'] = DBQuery::initial_cash_status();
    return $renderer->render($response, "tax_rates.php", $args);
})->setName('tax-rates');
