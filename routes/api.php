<?php

global $app;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;

$app->group('/api', function (RouteCollectorProxy $api) {

    $api->group('/cash-register', function (RouteCollectorProxy $cr_api){
        $cr_api->post('/new-cash-register', function (Request $request, Response $response, $args) {
            $description = $request->getParsedBody()['description'];
            $success = DBQuery::create_cash_register($description);
            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('new-cash-register');

        $cr_api->post('/delete-cash-register', function (Request $request, Response $response, $args){
            $id_cash_register = $request->getParsedBody()['id_cash_register'];
            $success = DBQuery::delete_cash_register($id_cash_register);
            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('delete-cash-register');

        $cr_api->post('/edit-cash-status', function (Request $request, Response $response, $args){
            $data = $request->getParsedBody()['postData'];
            $success = DBQuery::edit_initial_cash_status($data['id_cash_status'],$data['date'], $data['amount'], $data['id_cash_register']);
            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('edit-cash-status');

        $cr_api->post('/delete-tax-rate', function (Request $request, Response $response, $args){
            $id_tax_rate = $request->getParsedBody()['id_tax_rate'];
            if (DBQuery::get_revenues_with_tax_rate($id_tax_rate) > 0) {
                $success = false;
            } else {
                $success = DBQuery::delete_tax_rate($id_tax_rate);
            }

            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('delete-tax-rate');

        $cr_api->post('/new-tax-rate', function (Request $request, Response $response, $args) {
            $data = $request->getParsedBody()['postData'];
            $success = DBQuery::create_tax_rate($data['tax_rate'], $data['description']);
            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('new-tax-rate');
    });

    $api->group('/revenue', function (RouteCollectorProxy $revenue_api){
        $revenue_api->post('/new-revenue', function (Request $request, Response $response, $args) {
            $data = $request->getParsedBody()['postData'];
            $success = DBQuery::create_revenue($data['description'], $data['date'],  $data['amount'],$data['id_cash_register'], $data['id_tax_rate']);
            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('new-revenue');

        $revenue_api->post('/delete-revenue', function (Request $request, Response $response, $args){
            $id_revenue = $request->getParsedBody()['id_revenue'];
            $success = DBQuery::delete_revenue($id_revenue);
            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('delete-revenue');

        $revenue_api->post('/new-expense', function (Request $request, Response $response, $args) {
            $data = $request->getParsedBody()['postData'];
            $success = DBQuery::create_expense($data['description'], $data['date'],  $data['amount'],$data['id_cash_register'], $data['id_tax_rate']);
            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('new-expense');

        $revenue_api->post('/delete-expense', function (Request $request, Response $response, $args){
            $id_expense = $request->getParsedBody()['expense'];
            $success = DBQuery::delete_revenue($id_expense);
            $response->getBody()->write(json_encode(array("success" => $success)));
            return $response;
        })->setName('delete-expense');
    });

    $api->get('/db-init', function () {
        global  $db;
        $dbi = new DBInitializer();
        $dbi->initialize($db);
        exit;
    })->setName('db-init');

    $api->get('/tables', function (Request $request, Response $response, $args) {
        global $db;
        $response->getBody()->write(json_encode($db->get_tables()));
        return $response;
    })->setName('tables');
});

