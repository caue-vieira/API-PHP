<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

require_once "src/config/router.php";
require_once "src/config/autoload.php";

$router = new Router();

$router->addRoute("GET", "api/view/{viewName}", ["ViewController", "renderView"]);
$router->addRoute("GET", "api/turnos/buscar", ["TurnosController", "buscarTurnos"]);
$router->addRoute("POST", "api/turnos/cadastrar", ["TurnosController", "cadastraTurno"]);

$router->handleRequest();