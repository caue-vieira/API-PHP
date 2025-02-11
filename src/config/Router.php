<?php
class Router {
    private $routes = [];

    public function addRoute($method, $path, $handler) {
        $this->routes[] = [
            "method" => strtoupper($method),
            "path" => $path,
            "handler" => $handler,
        ];
    }

    public function handleRequest() {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        $requestUri = str_replace(["/teste php", "/teste%20php"], "", $requestUri);
        $requestUri = trim($requestUri, "/");

        foreach($this->routes as $route) {
            $pattern = preg_replace("/{([^}]+)}/", "([^/]+)", $route['path']);
            if($route['method'] === $requestMethod && preg_match("#^$pattern$#", $requestUri, $matches)) {
                array_shift($matches);

                $controllerName = $route['handler'][0];
                $methodName = $route['handler'][1];

                require_once __DIR__ . "/../controllers/" . $controllerName . ".php";

                $controllerInstance = new $controllerName();
                call_user_func_array([$controllerInstance, $methodName], $matches);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => "Rota não encontrada"]);
    }
}