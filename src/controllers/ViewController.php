<?php
namespace App\Controllers;

class ViewController {
    public static function renderView() {
        header("Content-Type: text/html");
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $parts = explode("/", trim($uri, "/"));
        $viewName = end($parts);

        $viewPath = __DIR__ . "/../views/" . $viewName . ".php";

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            http_response_code(404);
            echo "View não encontrada";
        }
    }
}