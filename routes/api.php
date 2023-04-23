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
        })->setName('delete-cash-register');;
    });

    $api->get('/db-init', function () {
        global  $db;
        $dbi = new DBInitializer();
        $dbi->initialize($db);
        exit;
    })->setName('phpinfo');

    $api->get('/tables', function (Request $request, Response $response, $args) {
        global $db;
        $response->getBody()->write(json_encode($db->get_tables()));
        return $response;
    })->setName('tables');



    $api->post('/example', function (Request $request, Response $response, $args){
        $response->getBody()->write(json_encode($request->getParsedBody()));
        return $response;
    });

});

