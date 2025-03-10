<?php
namespace App\Config\Http;

use App\Errors\NoBodyException;

class Request {
    private array $data;

    public function __construct() {
        $json = file_get_contents("php://input");
        if(!$json) {
            throw new NoBodyException("Não foi possível processar a requisição", 400);
        }
        $this->data = json_decode($json, true);
    }

    public function input(string $key, $default = null) {
        return $this->data[$key] ?? $default;
    }

    public function all(): array {
        return $this->data;
    }
}