<?php
namespace App\Config\Logs;

use Throwable;

class ErrorHandler {
    public static function handleException(Throwable $e): void {
        Logger::log($e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine(), "ERROR");

        http_response_code($e->getCode());
        echo json_encode(["message" => $e->getMessage()]);
    }
}