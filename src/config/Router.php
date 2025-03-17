<?php
namespace App\Config;

use ReflectionClass;
use ReflectionMethod;
use App\Config\Routes\Route;
use App\Errors\NoBodyException;
use App\Config\Http\Request;

class Router {
    private array $routes = [];

    public function __construct() {
        $this->loadRoutes();
    }

    private function loadRoutes() {
        $controllerFiles = glob(__DIR__ . "/../controllers/*Controller.php");

        foreach ($controllerFiles as $file) {
            require_once $file;
            $className = basename($file, ".php");
            $fullClassName = "App\\Controllers\\$className";

            if (class_exists($fullClassName)) {
                $reflectionClass = new ReflectionClass($fullClassName);

                foreach ($reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                    $attributes = $method->getAttributes(Route::class);
                    foreach ($attributes as $attribute) {
                        $routeInstance = $attribute->newInstance();
                        $this->addRoute($routeInstance->method, $routeInstance->path, [$fullClassName, $method->getName()]);
                    }
                }
            }
        }
    }

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            "method" => strtoupper($method),
            "path" => $path,
            "handler" => $handler,
        ];
    }

    public function handleRequest() {
        $requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        $requestUri = str_replace(["/teste%20php", "/teste php"], "", $requestUri);
        $requestUri = trim($requestUri, "/");

        foreach ($this->routes as $route) {
            $pattern = preg_replace("/{([^}]+)}/", "([^/]+)", $route["path"]);
            if ($route["method"] === $requestMethod && preg_match("#^$pattern$#", $requestUri, $matches)) {
                array_shift($matches);

                $controllerName = $route["handler"][0];
                $methodName = $route["handler"][1];

                $controllerInstance = new $controllerName();

                try {
                    if ($requestMethod !== "GET") {
                        $request = new Request();
                        array_unshift($matches, $request);
                    }

                    call_user_func_array([$controllerInstance, $methodName], $matches);
                } catch (NoBodyException $e) {
                    http_response_code($e->getCode());
                    echo json_encode(["message" => $e->getMessage()]);
                }
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "Rota não encontrada", $requestUri]);
    }
}