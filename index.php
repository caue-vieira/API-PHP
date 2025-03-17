<?php
namespace Index;

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

$router->handleRequest();