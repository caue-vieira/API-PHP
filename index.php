<?php
namespace Index;

/* 
Arquivos da api para verificar alterações no create-project:

src/config/http/request.php
src/config/logs/ErrorHandler.php
src/config/logs/Logger.php
src/config/autoload.php
src/config/router.php

src/middleware/requestLogger.php

console
index.php
*/

use App\Config\Logs\ErrorHandler;
use App\Config\Router;
use App\Middleware\RequestLogger;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");


require_once "src/config/autoload.php";
require_once "src/config/router.php";

RequestLogger::logRequest();
set_exception_handler([ErrorHandler::class, "handleException"]);

$router = new Router();

$router->addRoute("GET", "api/view/{viewName}", ["ViewController", "renderView"]);
$router->addRoute("GET", "api/usuarios/buscar", ["UsuariosController", "buscarUsuarios"]);
$router->addRoute("POST", "api/usuarios/cadastrar", ["UsuariosController", "cadastraUsuario"]);
$router->addRoute("POST", "api/login", ["UsuariosController", "login"]);

$router->handleRequest();