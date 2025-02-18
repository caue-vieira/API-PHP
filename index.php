<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

require_once "src/config/autoload.php";
require_once "src/config/router.php";

$router = new Router();

$router->addRoute("GET", "api/view/{viewName}", ["ViewController", "renderView"]);
$router->addRoute("GET", "api/usuarios/buscar", ["UsuariosController", "buscarUsuarios"]);
$router->addRoute("POST", "api/usuarios/cadastrar", ["UsuariosController", "cadastraUsuario"]);

$router->handleRequest();