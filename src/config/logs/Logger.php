<?php
namespace App\Config\Logs;

class Logger {
    private static string $logFile = __DIR__ . "/app.log";

    public static function log(string $message, string $level = "INFO"): void {
        $date = date("Y-m-d H:i:s");
        $logMessage = "[$date] [$level] $message" . PHP_EOL;

        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }
}