<?php
namespace App\Http;

class Request {
    private array $data;

    public function __construct() {
        $json = file_get_contents("php://input");
        $this->data = json_decode($json, true);
    }

    public function input(string $key, $default = null) {
        return $this->data[$key] ?? $default;
    }

    public function all(): array {
        return $this->data;
    }
}