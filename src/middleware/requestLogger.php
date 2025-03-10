<?php
namespace App\Middleware;

use App\Config\Logs\Logger;

class RequestLogger {
    public static function logRequest(): void {
        $method = $_SERVER["REQUEST_METHOD"] ?? "UNKNOWN";
        $uri = $_SERVER["REQUEST_URI"] ?? "UNKNOWN";
        $ip = $_SERVER["REMOTE_ADDR"] ?? "UNKNOWN";

        Logger::log("Nova requisição: [$method] $uri de $ip", "REQUEST");
    }
}