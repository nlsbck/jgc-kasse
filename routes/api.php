<?php

global $app;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;

$app->group('/api', function (RouteCollectorProxy $api) {

    $api->group('/cash-register', function (RouteCollectorProxy $cr_api){
        $cr_api->post('/new-cash-register', function (Request $request, Response $response, $args) {
            $description = $request->getParsedBody()['description'];
            DBQuery::create_cash_register($description);
            $response->getBody()->write(json_encode(array("success" => true)));
            return $response;
        })->setName('new-cash-register');

        $cr_api->post('/delete-cash-register', function (Request $request, Response $response, $args){
            $id_cash_register = $request->getParsedBody()['id_cash_register'];
            DBQuery::delete_cash_register($id_cash_register);
            $response->getBody()->write(json_encode(array("success" => true)));
            return $response;
        })->setName('delete-cash-register');

        $cr_api->post('/edit-cash-status', function (Request $request, Response $response, $args){
            $data = $request->getParsedBody()['postData'];
            DBQuery::edit_initial_cash_status($data['id_cash_status'],$data['date'], $data['amount'], $data['id_cash_register']);
            $response->getBody()->write(json_encode(array("success" => true)));
            return $response;
        })->setName('edit-cash-status');
    });

    $api->group('/revenue', function (RouteCollectorProxy $revenue_api){
        $revenue_api->post('/new-revenue', function (Request $request, Response $response, $args) {
            $data = $request->getParsedBody()['postData'];
            DBQuery::create_revenue($data['description'], $data['date'],  $data['amount'],$data['id_cash_register'], $data['id_tax_rate']);
            $response->getBody()->write(json_encode(array("success" => true)));
            return $response;
        })->setName('new-revenue');
        $revenue_api->post('/delete-revenue', function (Request $request, Response $response, $args){
            $id_revenue = $request->getParsedBody()['id_revenue'];
            DBQuery::delete_revenue($id_revenue);
            $response->getBody()->write(json_encode(array("success" => true)));
            return $response;
        })->setName('delete-revenue');
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

